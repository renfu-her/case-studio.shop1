<?php

namespace App\Services;

use App\Models\Category;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Components\FileUpload;
use Rawilk\FilamentQuill\Filament\Forms\Components\QuillEditor;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class ProductService
{
    public function getFormSchema(): array
    {
        return [
            $this->getCategorySelect(),
            $this->getImageUpload(),
            $this->getNameInput(),
            $this->getDescriptionEditor(),
            $this->getPriceInput(),
            $this->getStockInput(),
            $this->getStatusToggle(),
        ];
    }

    private function getCategorySelect()
    {
        return Forms\Components\Select::make('category_id')
            ->relationship('category', 'name')
            ->label('商品分類')
            ->required()
            ->searchable()
            ->preload()
            ->options(fn() => $this->getCategoryOptions())
            ->createOptionForm([
                Forms\Components\Select::make('parent_id')
                    ->relationship('parent', 'name')
                    ->label('上層分類')
                    ->searchable()
                    ->preload()
                    ->options(fn() => $this->getCategoryOptions()),
                Forms\Components\TextInput::make('name')
                    ->label('分類名稱')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sort')
                    ->label('排序')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('啟用狀態')
                    ->default(true),
            ]);
    }

    private function getImageUpload()
    {
        return FileUpload::make('image')
            ->label('主圖片')
            ->image()
            ->imageEditor()
            ->directory('products')
            ->columnSpanFull()
            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
            ->imageResizeMode('cover')
            ->imageResizeTargetWidth('1024')
            ->imageResizeTargetHeight('1024')
            ->saveUploadedFileUsing(fn($file) => $this->handleImageUpload($file));
    }

    private function getNameInput()
    {
        return Forms\Components\TextInput::make('name')
            ->label('商品名稱')
            ->required()
            ->maxLength(255);
    }

    private function getDescriptionEditor()
    {
        return QuillEditor::make('description')
            ->label('商品描述')
            ->placeholder('請輸入商品描述...')
            ->columnSpanFull();
    }

    private function getPriceInput()
    {
        return Forms\Components\TextInput::make('price')
            ->label('價格')
            ->required()
            ->numeric()
            ->prefix('NT$');
    }

    private function getStockInput()
    {
        return Forms\Components\TextInput::make('stock')
            ->label('庫存')
            ->required()
            ->numeric()
            ->default(0)
            ->minValue(0);
    }

    private function getStatusToggle()
    {
        return Forms\Components\Toggle::make('is_active')
            ->label('啟用狀態')
            ->default(true);
    }

    public function getTableColumns(): array
    {
        return [
            $this->getImageColumn(),
            $this->getCategoryColumn(),
            $this->getNameColumn(),
            $this->getPriceColumn(),
            $this->getStockColumn(),
            $this->getStatusColumn(),
        ];
    }

    private function getImageColumn()
    {
        return Tables\Columns\ImageColumn::make('image')
            ->label('主圖片');
    }

    private function getCategoryColumn()
    {
        return Tables\Columns\TextColumn::make('category.name')
            ->label('商品分類')
            ->formatStateUsing(fn($record) => $this->formatCategoryPath($record))
            ->searchable()
            ->sortable();
    }

    private function getNameColumn()
    {
        return Tables\Columns\TextColumn::make('name')
            ->label('商品名稱')
            ->searchable()
            ->sortable();
    }

    private function getPriceColumn()
    {
        return Tables\Columns\TextColumn::make('price')
            ->label('價格')
            ->money('TWD')
            ->sortable();
    }

    private function getStockColumn()
    {
        return Tables\Columns\TextColumn::make('stock')
            ->label('庫存')
            ->sortable();
    }

    private function getStatusColumn()
    {
        return Tables\Columns\IconColumn::make('is_active')
            ->label('啟用狀態')
            ->boolean()
            ->sortable();
    }

    public function getTableFilters(): array
    {
        return [
            Tables\Filters\TernaryFilter::make('is_active')
                ->label('商品狀態')
                ->placeholder('全部商品')
                ->trueLabel('已啟用')
                ->falseLabel('已停用'),
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

    public function getCategoryOptions()
    {
        $categories = Category::all();
        $topCategories = $categories->whereNull('parent_id');

        return $this->buildCategoryOptions($topCategories, $categories);
    }

    private function buildCategoryOptions($items, $categories, $depth = 0)
    {
        $options = [];
        foreach ($items as $category) {
            $prefix = str_repeat('　', $depth);
            $options[$category->id] = $prefix . ($depth > 0 ? '|-' : '') . $category->name;

            $children = $categories->where('parent_id', $category->id);
            if ($children->count() > 0) {
                $options += $this->buildCategoryOptions($children, $categories, $depth + 1);
            }
        }
        return $options;
    }

    public function handleImageUpload($file)
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);
        $image->cover(1024, 1024);

        $filename = Str::uuid()->toString() . '.webp';

        if (!file_exists(storage_path('app/public/products'))) {
            mkdir(storage_path('app/public/products'), 0755, true);
        }

        $image->toWebp(80)->save(storage_path('app/public/products/' . $filename));

        return 'products/' . $filename;
    }

    public function formatCategoryPath($record): string
    {
        if (!$record->category) {
            return '';
        }

        $path = [];
        $category = $record->category;

        while ($category) {
            array_unshift($path, $category->name);
            $category = $category->parent;
        }

        return implode(' -> ', $path);
    }
}
