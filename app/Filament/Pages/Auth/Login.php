<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Button;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
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

    public function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
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
                        \Filament\Forms\Components\Actions::make([
                            \Filament\Forms\Components\Actions\Action::make('login')
                                ->label('登入')
                                ->submit('login')
                                ->color('primary')
                                ->icon('heroicon-m-arrow-right-on-rectangle')
                                ->size('lg')
                                ->buttonAttribute('type', 'submit')
                                ->extraAttributes([
                                    'class' => 'w-full justify-center'
                                ]),
                        ])
                            ->columnSpan('full')
                            ->alignEnd()
                    ])
            ),
        ];
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email' => $data['data']['email'],
            'password' => $data['data']['password'],
        ];
    }
}
