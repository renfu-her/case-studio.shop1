<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\View;
use Illuminate\Validation\ValidationException;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;

class Login extends BaseLogin
{
    public ?array $data = [
        'email' => null,
        'password' => null,
        'captcha' => null,
    ];

    protected static string $view = 'filament.pages.auth.login';

    public function getTitle(): string
    {
        return '後台管理系統';
    }

    public function getBrandName(): string
    {
        return '後台管理系統';
    }

    public function getHeading(): string
    {
        return '登入系統';
    }

    protected function getLayoutLogoUrl(): ?string
    {
        return asset('images/logo.png');
    }

    protected function getLayoutLogoHeight(): ?string
    {
        return '50px';
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('data.email')
                                    ->label('電子郵件')
                                    ->email()
                                    ->required()
                                    ->autocomplete()
                                    ->placeholder('請輸入電子郵件')
                                    ->columnSpan('full'),
                                TextInput::make('data.password')
                                    ->label('密碼')
                                    ->password()
                                    ->required()
                                    ->placeholder('請輸入密碼')
                                    ->columnSpan('full'),
                                View::make('components.captcha-input')
                                    ->columnSpan('full'),
                                \Filament\Forms\Components\Actions::make([
                                    \Filament\Forms\Components\Actions\Action::make('login')
                                        ->label('登入')
                                        ->submit('login')
                                        ->color('primary')
                                        ->icon('heroicon-m-arrow-right-on-rectangle')
                                        ->size('lg')
                                        ->extraAttributes([
                                            'class' => 'w-full justify-center'
                                        ]),
                                ])
                                    ->columnSpan('full')
                                    ->alignEnd(),
                            ])
                    ])
            ),
        ];
    }

    protected function getFormActions(): array
    {
        return [];
    }

    protected function hasFullWidthFormActions(): bool
    {
        return false;
    }

    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        // 驗證驗證碼
        if (!$this->validateCaptcha($data['captcha'] ?? null)) {
            throw ValidationException::withMessages([
                'captcha' => '驗證碼不正確',
            ]);
        }

        return parent::authenticate();
    }

    protected function validateCaptcha($input): bool
    {
        if (empty($input)) {
            return false;
        }
        $captcha = session('captcha');
        return $input === $captcha;
    }
}
