<?php

namespace App\Services;

use Filament\Forms\Components\FileUpload;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class ProductImageService extends BaseService
{
    public function getFormSchema(): array
    {
        return [
            $this->createImageUpload(
                name: 'image',
                label: '圖片',
                directory: 'product-images',
                required: true,
                saveUploadedFileUsing: function ($file) {
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($file);
                    $image->cover(1024, 1024);

                    $filename = Str::uuid()->toString() . '.webp';

                    if (!file_exists(storage_path('app/public/product-images'))) {
                        mkdir(storage_path('app/public/product-images'), 0755, true);
                    }

                    $image->toWebp(80)->save(storage_path('app/public/product-images/' . $filename));

                    return 'product-images/' . $filename;
                }
            ),
            $this->createNumberInput(
                name: 'sort',
                label: '排序',
                default: false
            ),
        ];
    }

    public function getTableColumns(): array
    {
        return [
            $this->createImageColumn(
                name: 'image',
                label: '圖片'
            ),
            $this->createTextColumn(
                name: 'sort',
                label: '排序',
                sortable: true
            ),
        ];
    }

    public function getTableActions(): array
    {
        return [
            \Filament\Tables\Actions\EditAction::make()
                ->label('編輯'),
            \Filament\Tables\Actions\DeleteAction::make()
                ->label('刪除'),
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            \Filament\Tables\Actions\BulkActionGroup::make([
                \Filament\Tables\Actions\DeleteBulkAction::make()
                    ->label('刪除所選'),
            ]),
        ];
    }

    public function getHeaderActions(): array
    {
        return [
            \Filament\Tables\Actions\CreateAction::make()
                ->label('新增圖片'),
        ];
    }
}
