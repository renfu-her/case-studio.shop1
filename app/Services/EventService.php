<?php

namespace App\Services;

use Filament\Forms;
use Filament\Tables;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use Filament\Forms\Components\Toggle;

class EventService extends BaseService
{
    public function getFormSchema(): array
    {
        return [
            $this->getTitleInput(),
            $this->getImageUpload('上傳圖片長寬：1200px x 630px'),
            $this->getContentEditor(),
            $this->getStartDatePicker(),
            $this->getEndDatePicker(),
            $this->getSortInput(),
            Toggle::make('is_active')
                ->label('啟用狀態')
                ->inline(false)
                ->default(true)
                ->columnSpanFull(),
        ];
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

    private function getImageUpload(string $placeholder = null)
    {
        return $this->createImageUpload(
            name: 'image',
            label: '活動圖片',
            directory: 'events',
            columnSpanFull: true,
            placeholder: $placeholder,
            acceptedFileTypes: ['image/jpeg', 'image/png'],
            saveUploadedFileUsing: fn($file) => $this->handleImageUpload($file)
        );
    }

    private function getContentEditor()
    {
        return $this->createQuillEditor(
            'content',
            '活動內容',
            '請輸入活動內容...'
        );
    }

    private function getStartDatePicker()
    {
        return $this->createDateTimePicker(
            'start_date',
            '開始日期',
            true
        );
    }

    private function getEndDatePicker()
    {
        return $this->createDateTimePicker(
            'end_date',
            '結束日期',
            true
        );
    }

    private function getSortInput()
    {
        return $this->createNumberInput(
            'sort',
            '排序',
            false,
            0
        );
    }

    public function getTableColumns(): array
    {
        return [
            $this->getImageColumn(),
            $this->getTitleColumn(),
            $this->getStartDateColumn(),
            $this->getEndDateColumn(),
            $this->getSortColumn(),
            $this->getStatusColumn(),
        ];
    }

    private function getImageColumn()
    {
        return $this->createImageColumn(
            'image',
            '活動圖片'
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

    private function getStartDateColumn()
    {
        return $this->createDateTimeColumn(
            'start_date',
            '開始日期'
        );
    }

    private function getEndDateColumn()
    {
        return $this->createDateTimeColumn(
            'end_date',
            '結束日期'
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

    private function handleImageUpload($file)
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);
        $image->cover(1200, 630);

        $filename = Str::uuid()->toString() . '.webp';

        if (!file_exists(storage_path('app/public/events'))) {
            mkdir(storage_path('app/public/events'), 0755, true);
        }

        $image->toWebp(80)->save(storage_path('app/public/events/' . $filename));

        return 'events/' . $filename;
    }
}
