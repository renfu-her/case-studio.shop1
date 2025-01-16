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
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label('商品分類')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->options(function () {
                        // 獲取所有分類並組織成階層結構
                        $categories = \App\Models\Category::all();
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
                    ->createOptionForm([
                        Forms\Components\Select::make('parent_id')
                            ->relationship('parent', 'name')
                            ->label('上層分類')
                            ->searchable()
                            ->preload()
                            ->options(function () {
                                // 在創建新分類時也使用相同的階層結構
                                $categories = \App\Models\Category::all();
                                $topCategories = $categories->whereNull('parent_id');

                                $buildOptions = function ($items, $depth = 0) use (&$buildOptions, $categories) {
                                    $options = [];
                                    foreach ($items as $category) {
                                        $prefix = str_repeat('　', $depth);
                                        $options[$category->id] = $prefix . ($depth > 0 ? '|-' : '') . $category->name;

                                        $children = $categories->where('parent_id', $category->id);
                                        if ($children->count() > 0) {
                                            $options += $buildOptions($children, $depth + 1);
                                        }
                                    }
                                    return $options;
                                };

                                return $buildOptions($topCategories);
                            }),
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
                    ]),
                FileUpload::make('image')
                    ->label('主圖片')
                    ->image()
                    ->imageEditor()
                    ->directory('products')
                    ->columnSpanFull()
                    ->acceptedFileTypes(['image/jpeg', 'image/png'])
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth('1024')
                    ->imageResizeTargetHeight('1024')
                    ->saveUploadedFileUsing(function ($file) {
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
                    }),
                Forms\Components\TextInput::make('name')
                    ->label('商品名稱')
                    ->required()
                    ->maxLength(255),
                QuillEditor::make('description')
                    ->label('商品描述')
                    ->placeholder('請輸入商品描述...')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->label('價格')
                    ->required()
                    ->numeric()
                    ->prefix('NT$'),
                Forms\Components\TextInput::make('stock')
                    ->label('庫存')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('啟用狀態')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('主圖片'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('商品分類')
                    ->formatStateUsing(function ($record): string {
                        if (!$record->category) {
                            return '';
                        }

                        // 建立分類路徑
                        $path = [];
                        $category = $record->category;

                        // 遞迴向上查找父級分類
                        while ($category) {
                            array_unshift($path, $category->name);
                            $category = $category->parent;
                        }

                        // 用箭頭連接分類名稱
                        return implode(' -> ', $path);
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('商品名稱')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('價格')
                    ->money('TWD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock')
                    ->label('庫存')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('啟用狀態')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('商品狀態')
                    ->placeholder('全部商品')
                    ->trueLabel('已啟用')
                    ->falseLabel('已停用'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('編輯'),
                Tables\Actions\DeleteAction::make()
                    ->label('刪除'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('刪除所選'),
                ]),
            ])
            ->emptyStateHeading('尚無商品')
            ->emptyStateDescription('開始建立您的第一個商品')
            ->defaultSort('created_at', 'desc')
            ->searchPlaceholder('搜尋商品')
            ->filtersTriggerAction(
                fn($action) => $action
                    ->label('篩選')
            );
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
