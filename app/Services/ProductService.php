<?php

namespace App\Services;

use App\Models\Category;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Rawilk\FilamentQuill\Filament\Forms\Components\QuillEditor;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class ProductService extends BaseService
{
    public function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('基本資料')
                ->schema([
                    Select::make('category_id')
                        ->relationship('category', 'name')
                        ->required()
                        ->label('分類'),
                    TextInput::make('name')
                        ->required()
                        ->label('商品名稱'),
                    RichEditor::make('sub_title')
                        ->label('副標題')
                        ->columnSpanFull(),
                    $this->createTinyMceEditor('description', '商品描述')
                        ->required()
                        ->columnSpanFull(),
                    $this->createImageUpload(
                        name: 'image',
                        label: '主要圖片',
                        directory: 'products',
                        placeholder: '上傳圖片長寬：1024px x 1024px',
                        required: true,
                        saveUploadedFileUsing: fn($file, $get) => $this->handleImageUpload($file, $get)
                    ),
                    TextInput::make('price')
                        ->numeric()
                        ->required()
                        ->label('售價'),
                    TextInput::make('stock')
                        ->numeric()
                        ->required()
                        ->default(0)
                        ->label('庫存'),
                    Toggle::make('is_active')
                        ->label('啟用')
                        ->default(true),
                    Toggle::make('is_hot')
                        ->label('熱門商品')
                        ->default(false),
                    Toggle::make('is_new')
                        ->label('新品')
                        ->default(false),
                ])
                ->columns(2),
        ];
    }

    private function getCategorySelect()
    {
        return $this->createRelationSelect(
            'category_id',
            '商品分類',
            'category',
            'name',
            true,
            true,
            true,
            fn() => $this->getCategoryOptions(),
            [
                $this->createRelationSelect('parent_id', '上層分類', 'parent', 'name', false, true, true, fn() => $this->getCategoryOptions()),
                $this->createTextInput('name', '分類名稱', true, 255),
                $this->createNumberInput('sort', '排序', false, 0),
                $this->createToggle('is_active', '啟用狀態'),
            ]
        );
    }

    private function getImageUpload(string $placeholder = null)
    {
        return $this->createImageUpload(
            name: 'image',
            label: '主圖片',
            directory: 'products',
            columnSpanFull: true,
            placeholder: $placeholder,
            acceptedFileTypes: ['image/jpeg', 'image/jpg', 'image/png'],
            saveUploadedFileUsing: fn($file) => $this->handleImageUpload($file)
        );
    }

    private function getNameInput()
    {
        return $this->createTextInput('name', '商品名稱', true, 255);
    }

    private function getDescriptionEditor()
    {
        return $this->createTinyMceEditor(name: 'description', label: '商品描述', placeholder: '請輸入商品描述...');
    }

    private function getPriceInput()
    {
        return $this->createNumberInput('price', '價格', true, null, null, 'NT$');
    }

    private function getStockInput()
    {
        return $this->createNumberInput('stock', '庫存', true, 0);
    }

    private function getStatusToggle()
    {
        return $this->createToggle('is_active', '啟用狀態');
    }

    private function getHotToggle()
    {
        return $this->createToggle('is_hot', '熱銷商品');
    }

    private function getNewToggle()
    {
        return $this->createToggle('is_new', '新上架');
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
            $this->getHotColumn(),
            $this->getNewColumn(),
        ];
    }

    private function getImageColumn()
    {
        return $this->createImageColumn('image', '主圖片');
    }

    private function getCategoryColumn()
    {
        return $this->createTextColumn(
            'category.name',
            '商品分類',
            true,
            true,
            fn($record) => $this->formatCategoryPath($record)
        );
    }

    private function getNameColumn()
    {
        return $this->createTextColumn('name', '商品名稱', true, true);
    }

    private function getPriceColumn()
    {
        return $this->createMoneyColumn('price', '價格');
    }

    private function getStockColumn()
    {
        return $this->createTextColumn('stock', '庫存', false, true);
    }

    private function getStatusColumn()
    {
        return $this->createBooleanColumn(
            'is_active',
            '啟用狀態'
        );
    }

    private function getHotColumn()
    {
        return $this->createBooleanColumn('is_hot', '熱銷商品');
    }

    private function getNewColumn()
    {
        return $this->createBooleanColumn('is_new', '新上架');
    }

    public function getTableFilters(): array
    {
        return [
            Tables\Filters\TernaryFilter::make('is_active')
                ->label('商品狀態')
                ->placeholder('全部商品')
                ->trueLabel('已啟用')
                ->falseLabel('已停用'),
            Tables\Filters\TernaryFilter::make('is_hot')
                ->label('熱銷商品')
                ->placeholder('全部商品')
                ->trueLabel('是')
                ->falseLabel('否'),
            Tables\Filters\TernaryFilter::make('is_new')
                ->label('新上架')
                ->placeholder('全部商品')
                ->trueLabel('是')
                ->falseLabel('否'),
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

    public function handleImageUpload($file, $get)
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);

        // 調整圖片大小
        $image->cover(1024, 1024);

        // 生成唯一的檔案名
        $filename = Str::uuid()->toString() . '.webp';

        // 確保目錄存在
        if (!file_exists(storage_path('app/public/products'))) {
            mkdir(storage_path('app/public/products'), 0755, true);
        }

        // 轉換並保存為 WebP
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
