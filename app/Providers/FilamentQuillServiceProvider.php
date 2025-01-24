<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Rawilk\FilamentQuill\Facades\FilamentQuill;

class FilamentQuillServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        FilamentQuill::configureUsing(function ($component) {
            $component
                ->fonts([
                    '新細明體' => 'PMingLiU',
                    '微軟正黑體' => 'Microsoft JhengHei',
                    '標楷體' => 'DFKai-SB',
                    '細明體' => 'MingLiU',
                ])
                ->fontSizes([
                    '12px',
                    '14px',
                    '16px',
                    '18px',
                    '20px',
                    '24px',
                    '28px',
                    '32px',
                    '36px',
                ]);
        });
    }
}
