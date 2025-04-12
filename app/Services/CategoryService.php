<?php

namespace App\Services;

use App\Models\Category;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class CategoryService extends BaseService
{
    public function getFormSchema(): array
    {
        return [
            $this->getParentSelect(),
            $this->getNameInput(),
            $this->getImageUpload('上傳圖片長寬：1024px x 1024px'),
            $this->getSortInput(),
            Toggle::make('is_active')
                ->label('啟用狀態')
                ->inline(false)
                ->default(true)
                ->columnSpanFull(),
        ];
    }

    private function getParentSelect()
    {
        return Forms\Components\Select::make('parent_id')
            ->label('上層分類')
            ->options(function () {
                // 獲取所有分類並組織成階層結構
                $categories = Category::all();
                $options = [];

                // 先找出頂層分類
                $topCategories = $categories->whereNull('parent_id');

                // 遞迴函數來建立階層結構
                $buildOptions = function ($items, $depth = 0) use (&$buildOptions, $categories) {
                    $options = [];
                    foreach ($items as $category) {
                        $prefix = str_repeat('　', $depth);
                        $options[$category->id] = $prefix . ($depth > 0 ? '|-' : '') . $category->name;

                        // 找出此分類的子分類
                        $children = $categories->where('parent_id', $category->id);
                        if ($children->count() > 0) {
                            $options += $buildOptions($children, $depth + 1);
                        }
                    }
                    return $options;
                };

                return $buildOptions($topCategories);
            })
            ->searchable()
            ->placeholder('選擇上層分類');
    }

    private function getNameInput()
    {
        return $this->createTextInput(
            'name',
            '分類名稱',
            true,
            255
        );
    }

    private function getImageUpload(string $placeholder = null)
    {
        return $this->createImageUpload(
            name: 'image',
            label: '分類圖片',
            directory: 'categories',
            columnSpanFull: true,
            placeholder: $placeholder,
            acceptedFileTypes: ['image/jpeg', 'image/jpg', 'image/png'],
            saveUploadedFileUsing: fn($file) => $this->handleImageUpload($file)
        );
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
            $this->getNameColumn(),
            $this->getSortColumn(),
            $this->getStatusColumn(),
        ];
    }

    private function getImageColumn()
    {
        return $this->createImageColumn('image', '分類圖片')
            ->defaultImageUrl(asset('assets/images/no-image.png'));
    }

    private function getNameColumn()
    {
        return $this->createTextColumn(
            'name',
            '分類名稱',
            true,
            true,
            function (Category $record): string {
                // 手動查詢父級分類來確定深度
                $depth = 0;
                $parent_id = $record->parent_id;

                while ($parent_id) {
                    $depth++;
                    $parent = Category::find($parent_id);
                    if (!$parent) break;
                    $parent_id = $parent->parent_id;
                }

                $prefix = str_repeat('　', $depth);
                return $prefix . ($depth > 0 ? '|-' : '') . $record->name;
            }
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

    public function handleImageUpload($file)
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);
        $image->cover(1024, 1024);

        $filename = Str::uuid()->toString() . '.webp';

        if (!file_exists(storage_path('app/public/categories'))) {
            mkdir(storage_path('app/public/categories'), 0755, true);
        }

        $image->toWebp(80)->save(storage_path('app/public/categories/' . $filename));

        return 'categories/' . $filename;
    }
}
