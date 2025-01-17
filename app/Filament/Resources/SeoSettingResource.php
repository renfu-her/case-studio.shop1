<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeoSettingResource\Pages;
use App\Models\SeoSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;

class SeoSettingResource extends Resource
{
    protected static ?string $model = SeoSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = '網站管理';

    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'SEO 設定';

    protected static ?string $slug = 'seo-settings';

    

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('基本設定')
                    ->schema([
                        Forms\Components\TextInput::make('site_name')
                            ->label('網站名稱')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('title')
                            ->label('預設標題')
                            ->maxLength(60)
                            ->helperText('建議長度：40-60 字元'),

                        Forms\Components\Textarea::make('description')
                            ->label('預設描述')
                            ->maxLength(160)
                            ->helperText('建議長度：120-160 字元'),

                        Forms\Components\TextInput::make('keywords')
                            ->label('預設關鍵字')
                            ->helperText('以逗號分隔，例如：關鍵字1,關鍵字2'),
                    ]),

                Forms\Components\Section::make('社群分享設定')
                    ->schema([
                        Forms\Components\FileUpload::make('og_image')
                            ->label('預設 OG 圖片')
                            ->image()
                            ->directory('seo')
                            ->helperText('建議尺寸：1200x630 像素'),
                    ]),

                Forms\Components\Section::make('追蹤碼設定')
                    ->schema([
                        Forms\Components\TextInput::make('ga_id')
                            ->label('Google Analytics ID')
                            ->helperText('例如：G-XXXXXXXXXX 或 UA-XXXXXXXX-X'),

                        Forms\Components\TextInput::make('gtm_id')
                            ->label('Google Tag Manager ID')
                            ->helperText('例如：GTM-XXXXXX'),
                    ]),

                Forms\Components\Section::make('進階設定')
                    ->schema([
                        Forms\Components\Textarea::make('custom_tags')
                            ->label('自定義標籤')
                            ->helperText('可以添加其他 meta 標籤，每行一個')
                            ->rows(5),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\EditSeoSetting::route('/'),
        ];
    }
}
