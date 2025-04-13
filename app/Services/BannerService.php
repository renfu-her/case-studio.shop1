<?php

namespace App\Services;

use Filament\Forms;
use Filament\Tables;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use Filament\Forms\Components\Toggle;

class BannerService extends BaseService
{
    public function getFormSchema(): array
    {
        return [
            $this->getTypeSelect(),
            $this->getImageUpload('上傳圖片長寬：1920px x 600px'),
            $this->getTitleInput(),
            $this->getLinkInput(),
            $this->getSortInput(),
            Toggle::make('is_active')
                ->label('啟用狀態')
                ->inline(false)
                ->default(true)
                ->columnSpanFull(),
        ];
    }

    private function getTypeSelect()
    {
        return $this->createSelect(
            'type',
            '廣告類型',
            [
                'large' => '大型橫幅廣告 (1920px)',
                'small' => '小型廣告 (960px)',
            ],
            true
        );
    }

    private function getImageUpload(string $placeholder = null)
    {
        return $this->createImageUpload(
            name: 'image',
            label: '廣告圖片',
            directory: 'banners',
            placeholder: $placeholder,
            columnSpanFull: true,
            acceptedFileTypes: ['image/jpeg', 'image/png'],
            saveUploadedFileUsing: fn($file, $get) => $this->handleImageUpload($file, $get)
        );
    }

    private function getTitleInput()
    {
        return $this->createTextInput(
            'title',
            '標題',
            true,
            255
        );
    }

    private function getLinkInput()
    {
        return $this->createTextInput(
            'link',
            '連結網址',
            false,
            255
        )->url();
    }

    private function getSortInput()
    {
        return $this->createNumberInput(
            'sort',
            '排序',
            false,
            0
        )->default(0);
    }

    public function getTableColumns(): array
    {
        return [
            $this->getImageColumn(),
            $this->getTypeColumn(),
            $this->getTitleColumn(),
            $this->getSortColumn(),
            $this->getStatusColumn(),
        ];
    }

    private function getImageColumn()
    {
        return $this->createImageColumn(
            'image',
            '廣告圖片'
        );
    }

    private function getTypeColumn()
    {
        return $this->createTextColumn(
            'type',
            '類型',
            false,
            true,
            fn(string $state): string => match ($state) {
                'large' => '大型橫幅廣告',
                'small' => '小型廣告',
                default => $state,
            }
        );
    }

    private function getTitleColumn()
    {
        return $this->createTextColumn(
            'title',
            '標題',
            true,
            true
        );
    }

    private function getSortColumn()
    {
        return $this->createTextColumn(
            'sort',
            '排序',
            false,
            true
        );
    }

    private function getStatusColumn()
    {
        return $this->createBooleanColumn(
            'is_active',
            '啟用狀態'
        );
    }

    public function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('type')
                ->label('廣告類型')
                ->options([
                    'large' => '大型橫幅廣告',
                    'small' => '小型廣告',
                ]),
            Tables\Filters\TernaryFilter::make('is_active')
                ->label('啟用狀態'),
        ];
    }

    public function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make()
                ->label('編輯'),
            Tables\Actions\DeleteAction::make()
                ->label('刪除'),
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('刪除所選'),
            ]),
        ];
    }

    private function handleImageUpload($file, $get)
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);

        // 根據廣告類型設置尺寸
        $width = $get('type') === 'large' ? 1920 : 960;

        // 調整圖片大小
        $image->scale($width);

        // 生成唯一的檔案名
        $filename = Str::uuid()->toString() . '.webp';

        // 確保目錄存在
        if (!file_exists(storage_path('app/public/banners'))) {
            mkdir(storage_path('app/public/banners'), 0755, true);
        }

        // 轉換並保存為 WebP
        $image->toWebp(80)->save(storage_path('app/public/banners/' . $filename));

        return 'banners/' . $filename;
    }
}
