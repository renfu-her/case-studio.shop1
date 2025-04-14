<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers\ImagesRelationManager;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Rawilk\FilamentQuill\Filament\Forms\Components\QuillEditor;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use App\Filament\Resources\ProductResource\RelationManagers\ProductSpecsRelationManager;
use App\Services\ProductService;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = '商品管理';
    protected static ?string $navigationLabel = '商品管理';

    protected static ?string $modelLabel = '商品';

    protected static ?string $pluralModelLabel = '商品';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $productService = new ProductService();

        return $form->schema($productService->getFormSchema());
    }

    public static function table(Table $table): Table
    {
        $productService = new ProductService();

        return $table
            ->columns($productService->getTableColumns())
            ->filters($productService->getTableFilters())
            ->actions($productService->getTableActions())
            ->bulkActions($productService->getTableBulkActions())
            ->emptyStateHeading('尚無商品')
            ->emptyStateDescription('開始建立您的第一個商品')
            ->defaultSort('created_at', 'desc')
            ->searchPlaceholder('搜尋商品')
            ->filtersTriggerAction(
                fn($action) => $action->label('篩選')
            )
            ->paginated([10, 20, 30, 50, 100, 'all'])
            ->defaultPaginationPageOption(20);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            ImagesRelationManager::class,
            ProductSpecsRelationManager::class,
        ];
    }
}