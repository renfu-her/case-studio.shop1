<?php

namespace App\Filament\Pages;

use App\Models\SeoSetting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Filament\Notifications\Notification;

class SeoSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = '網站管理';

    protected static ?int $navigationSort = 2;

    protected static ?string $title = 'SEO 設定';

    protected static ?string $navigationLabel = 'SEO 設定';

    protected static ?string $slug = 'settings/seo';

    protected static string $view = 'filament.pages.seo-settings';

    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $settings = SeoSetting::first() ?? SeoSetting::create([
            'site_name' => config('app.name'),
        ]);

        $this->form->fill($settings->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('基本設定')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('網站名稱')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('title')
                            ->label('預設標題')
                            ->maxLength(60)
                            ->helperText('建議長度：40-60 字元'),

                        Textarea::make('description')
                            ->label('預設描述')
                            ->maxLength(160)
                            ->helperText('建議長度：120-160 字元'),

                        TextInput::make('keywords')
                            ->label('預設關鍵字')
                            ->helperText('以逗號分隔，例如：關鍵字1,關鍵字2'),
                    ]),

                Section::make('社群分享設定')
                    ->schema([
                        FileUpload::make('og_image')
                            ->label('預設 OG 圖片')
                            ->image()
                            ->directory('seo')
                            ->helperText('建議尺寸：1200x630 像素'),
                    ]),

                Section::make('追蹤碼設定')
                    ->schema([
                        TextInput::make('ga_id')
                            ->label('Google Analytics ID')
                            ->helperText('例如：G-XXXXXXXXXX 或 UA-XXXXXXXX-X'),

                        TextInput::make('gtm_id')
                            ->label('Google Tag Manager ID')
                            ->helperText('例如：GTM-XXXXXX'),
                    ]),

                Section::make('進階設定')
                    ->schema([
                        Textarea::make('custom_tags')
                            ->label('自定義標籤')
                            ->helperText('可以添加其他 meta 標籤，每行一個')
                            ->rows(5),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $settings = SeoSetting::first();
            $settings->update($this->form->getState());

            Notification::make()
                ->success()
                ->title('儲存成功')
                ->send();
        } catch (Halt $exception) {
            Notification::make()
                ->danger()
                ->title('儲存失敗')
                ->send();
        }
    }
}
