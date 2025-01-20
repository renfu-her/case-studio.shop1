<?php

namespace App\Services;

use Filament\Forms;
use Filament\Tables;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    public function getFormSchema(): array
    {
        return [
            $this->getNameInput(),
            $this->getEmailInput(),
            $this->getPasswordInput(),
            $this->getAdminToggle(),
            $this->getRolesSelect(),
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

    private function getAdminToggle()
    {
        return $this->createToggle(
            'is_admin',
            '管理員',
            false
        );
    }

    private function getRolesSelect()
    {
        return $this->createRelationSelect(
            'roles',
            '角色',
            'roles',
            'name',
            false,
            true,
            true
        )->multiple();
    }

    public function getTableColumns(): array
    {
        return [
            $this->getNameColumn(),
            $this->getEmailColumn(),
            $this->getAdminColumn(),
            $this->getRolesColumn(),
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

    private function getAdminColumn()
    {
        return $this->createBooleanColumn(
            'is_admin',
            '管理員'
        );
    }

    private function getRolesColumn()
    {
        return Tables\Columns\TextColumn::make('roles.name')
            ->label('角色')
            ->badge();
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
        return [
            Tables\Filters\TernaryFilter::make('is_admin')
                ->label('管理員')
                ->boolean()
                ->trueLabel('是')
                ->falseLabel('否')
                ->placeholder('全部'),
        ];
    }

    public function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make()
                ->label('編輯'),
            Tables\Actions\DeleteAction::make()
                ->label('刪除'),
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('刪除所選'),
            ]),
        ];
    }
}
