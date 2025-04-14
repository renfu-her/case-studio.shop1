<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeoSettingResource\Pages;
use App\Models\SeoSetting;
use App\Services\SeoSettingService;
use Filament\Forms\Form;
use Filament\Resources\Resource;

class SeoSettingResource extends Resource
{
    protected static ?string $model = SeoSetting::class;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema(
            app(SeoSettingService::class)->getFormSchema()
        );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\EditSeoSetting::route('/'),
        ];
    }
}