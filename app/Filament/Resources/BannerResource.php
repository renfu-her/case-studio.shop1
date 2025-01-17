<?php

namespace App\Filament\Resources;

use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use App\Filament\Resources\BannerResource\Pages;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = '網站管理';

    protected static ?string $navigationLabel = '廣告管理';
    protected static ?string $modelLabel = '廣告';
    protected static ?string $pluralModelLabel = '廣告';
    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('廣告類型')
                    ->options([
                        'large' => '大型橫幅廣告 (1920px)',
                        'small' => '小型廣告 (960px)',
                    ])
                    ->required(),

                FileUpload::make('image')
                    ->label('廣告圖片')
                    ->image()
                    ->imageEditor()
                    ->directory('banners')
                    ->columnSpanFull()
                    ->acceptedFileTypes(['image/jpeg', 'image/png'])
                    ->imageResizeMode('cover')
                    ->saveUploadedFileUsing(function ($file, $get) {
                        $manager = new ImageManager(new Driver());
                        $image = $manager->read($file);

                        // 根據廣告類型設置尺寸
                        $width = $get('type') === 'large' ? 1920 : 960;
                        $height = $get('type') === 'large' ? 600 : 400; // 高度可以依需求調整

                        // 調整圖片大小
                        $image->cover($width, $height);

                        // 生成唯一的檔案名
                        $filename = Str::uuid()->toString() . '.webp';

                        // 確保目錄存在
                        if (!file_exists(storage_path('app/public/banners'))) {
                            mkdir(storage_path('app/public/banners'), 0755, true);
                        }

                        // 轉換並保存為 WebP
                        $image->toWebp(80)->save(storage_path('app/public/banners/' . $filename));

                        return 'banners/' . $filename;
                    })
                    ->required(),

                Forms\Components\TextInput::make('title')
                    ->label('標題')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('link')
                    ->label('連結網址')
                    ->url()
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('廣告圖片'),

                Tables\Columns\TextColumn::make('type')
                    ->label('類型')
                    ->formatStateUsing(
                        fn(string $state): string =>
                        match ($state) {
                            'large' => '大型橫幅廣告',
                            'small' => '小型廣告',
                            default => $state,
                        }
                    ),

                Tables\Columns\TextColumn::make('title')
                    ->label('標題')
                    ->searchable(),

                Tables\Columns\TextColumn::make('sort')
                    ->label('排序')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('啟用狀態')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('廣告類型')
                    ->options([
                        'large' => '大型橫幅廣告',
                        'small' => '小型廣告',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('啟用狀態'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('編輯'),
                Tables\Actions\DeleteAction::make()->label('刪除'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('刪除所選'),
                ]),
            ])
            ->defaultSort('sort', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
