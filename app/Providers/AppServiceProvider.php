<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use App\Models\Event;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            LoginResponse::class,
            \App\Http\Responses\LoginResponse::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 共享 events 變數到所有視圖
        view()->share('events', Event::where('is_active', true)->get());
        
        // 分享類別數據到所有視圖
        view()->composer('*', function ($view) {
            $view->with('categories', Category::where('is_active', true)->get());
        });
    }
}
