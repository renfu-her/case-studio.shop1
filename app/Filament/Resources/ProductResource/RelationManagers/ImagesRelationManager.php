<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use App\Services\ProductImageService;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';
    protected static ?string $title = '商品圖片';
    protected static ?string $modelLabel = '商品圖片';
    protected static ?string $recordTitleAttribute = 'image';

    protected ProductImageService $service;

    public function __construct()
    {
        $this->service = new ProductImageService();
    }

    public function form(Form $form): Form
    {
        return $form->schema($this->service->getFormSchema());
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('商品圖片管理')
            ->description('可以上傳多張商品圖片')
            ->headerActions($this->service->getHeaderActions())
            ->columns($this->service->getTableColumns())
            ->defaultSort('sort')
            ->reorderable('sort')
            ->actions($this->service->getTableActions())
            ->bulkActions($this->service->getTableBulkActions())
            ->emptyStateHeading('尚無其他圖片')
            ->emptyStateDescription('新增更多商品圖片');
    }
}
