<?php

namespace App\Filament\Resources\SeoSettingResource\Pages;

use App\Filament\Resources\SeoSettingResource;
use Filament\Resources\Pages\EditRecord;
use App\Models\SeoSetting;

class EditSeoSetting extends EditRecord
{
    protected static string $resource = SeoSettingResource::class;

    public function mount(int|string $record = null): void
    {
        // 確保至少有一條記錄
        $settings = SeoSetting::first();

        if (!$settings) {
            $settings = SeoSetting::create([
                'site_name' => config('app.name'),
            ]);
        }

        // 設置記錄並調用父類的 mount 方法
        parent::mount($settings->id);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit');
    }

    // 禁用刪除按鈕
    protected function getHeaderActions(): array
    {
        return [];
    }
}
