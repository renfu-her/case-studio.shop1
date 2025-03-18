<?php

namespace App\Services;

use Filament\Forms;
use Filament\Tables;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class UserService extends BaseService
{
    public function getFormSchema(): array
    {
        return [
            $this->getNameInput(),
            $this->getEmailInput(),
            $this->getPasswordInput(),
        ];
    }

    private function getNameInput()
    {
        return $this->createTextInput(
            'name',
            '名稱',
            true,
            255
        );
    }

    private function getEmailInput()
    {
        return Forms\Components\TextInput::make('email')
            ->label('電子郵件')
            ->email()
            ->required()
            ->maxLength(255)
            ->unique(ignoreRecord: true);
    }

    private function getPasswordInput()
    {
        return Forms\Components\TextInput::make('password')
            ->label('密碼')
            ->password()
            ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
            ->required(fn(string $operation): bool => $operation === 'create')
            ->maxLength(255)
            ->hidden(fn(string $operation): bool => $operation === 'view')
            ->dehydrated(fn($state) => filled($state));
    }

    public function getTableColumns(): array
    {
        return [
            $this->getNameColumn(),
            $this->getEmailColumn(),
            $this->getCreatedAtColumn(),
        ];
    }

    private function getNameColumn()
    {
        return $this->createTextColumn(
            'name',
            '名稱',
            true,
            true
        );
    }

    private function getEmailColumn()
    {
        return $this->createTextColumn(
            'email',
            '電子郵件',
            true,
            true
        );
    }

    private function getCreatedAtColumn()
    {
        return $this->createDateTimeColumn(
            'created_at',
            '建立時間'
        );
    }

    public function getTableFilters(): array
    {
        return [];
    }

    public function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make()
                ->hidden(fn(User $record) => $record->email === 'demo@demo.com'),
            Tables\Actions\DeleteAction::make()
                ->hidden(fn(User $record) => $record->email === 'demo@demo.com'),
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()
                    ->action(function (Collection $records) {
                        if ($records->contains('email', 'demo@demo.com')) {
                            return;
                        }
                        $records->each->delete();
                    })
                    ->deselectRecordsAfterCompletion()
            ]),
        ];
    }
}
