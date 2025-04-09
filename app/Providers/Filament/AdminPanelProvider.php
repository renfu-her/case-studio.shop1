<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Rupadana\ApiService\ApiServicePlugin;
use App\Filament\Pages\Auth\Login;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('backend')
            ->path('backend')
            ->brandLogo(asset('images/purchase.png'))
            ->brandName('購物網站管理 DEMO')
            ->darkModeBrandLogo(asset('images/purchase.png'))
            ->brandLogoHeight('50px')
            ->favicon(asset('images/purchase.png'))
            ->darkMode(false)
            ->navigationGroups([
                '商品管理',
                '訂單管理',
                '銷售管理',
                '網站管理',
                '系統管理',
            ])
            ->colors([
                'primary' => '#217FCC',    // 亮藍色
                'danger' => '#CC2078',     // 玫瑰紅
                'gray' => '#145183',       // 中藍色
                'info' => '#20CCB2',       // 青色
                'success' => '#29CC20',    // 綠色
                'warning' => '#CC6E20',    // 橙色
            ])
            ->homeUrl('/admin/products')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->login(Login::class)
            ->plugins([
                ApiServicePlugin::make(),
            ]);
    }
}
