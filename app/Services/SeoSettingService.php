<?php

namespace App\Services;

use Filament\Forms;

class SeoSettingService extends BaseService
{
    public function getFormSchema(): array
    {
        return [
            $this->getBasicSection(),
            $this->getSocialSection(),
            $this->getTrackingSection(),
            $this->getAdvancedSection(),
        ];
    }

    private function getBasicSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make('基本設定')
            ->schema([
                $this->getSiteNameInput(),
                $this->getTitleInput(),
                $this->getDescriptionInput(),
                $this->getKeywordsInput(),
            ]);
    }

    private function getSocialSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make('社群分享設定')
            ->schema([
                $this->getOgImageUpload(),
            ]);
    }

    private function getTrackingSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make('追蹤碼設定')
            ->schema([
                $this->getGaIdInput(),
                $this->getGtmIdInput(),
            ]);
    }

    private function getAdvancedSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make('進階設定')
            ->schema([
                $this->getCustomTagsInput(),
            ]);
    }

    private function getSiteNameInput()
    {
        return $this->createTextInput(
            'site_name',
            '網站名稱',
            true,
            255
        );
    }

    private function getTitleInput()
    {
        return $this->createTextInput(
            'title',
            '預設標題',
            false,
            60
        )->helperText('建議長度：40-60 字元');
    }

    private function getDescriptionInput()
    {
        return Forms\Components\Textarea::make('description')
            ->label('預設描述')
            ->maxLength(160)
            ->helperText('建議長度：120-160 字元');
    }

    private function getKeywordsInput()
    {
        return $this->createTextInput(
            'keywords',
            '預設關鍵字',
            false,
            255
        )->helperText('以逗號分隔，例如：關鍵字1,關鍵字2');
    }

    private function getOgImageUpload()
    {
        return $this->createImageUpload(
            'og_image',
            '預設 OG 圖片',
            'seo',
            true,
            ['image/jpeg', 'image/png', 'image/webp']
        )->helperText('建議尺寸：1200x630 像素');
    }

    private function getGaIdInput()
    {
        return $this->createTextInput(
            'ga_id',
            'Google Analytics ID',
            false,
            255
        )->helperText('例如：G-XXXXXXXXXX 或 UA-XXXXXXXX-X');
    }

    private function getGtmIdInput()
    {
        return $this->createTextInput(
            'gtm_id',
            'Google Tag Manager ID',
            false,
            255
        )->helperText('例如：GTM-XXXXXX');
    }

    private function getCustomTagsInput()
    {
        return Forms\Components\Textarea::make('custom_tags')
            ->label('自定義標籤')
            ->helperText('可以添加其他 meta 標籤，每行一個')
            ->rows(5);
    }
}
