<?php

namespace App\Services;

use Filament\Forms;
use Filament\Tables;

class RoleService extends BaseService
{
    public function getFormSchema(): array
    {
        return [
            $this->getNameInput(),
            $this->getDescriptionInput(),
            $this->getPermissionsSelect(),
        ];
    }

    private function getNameInput()
    {
        return $this->createTextInput(
            'name',
            '角色名稱',
            true,
            255
        );
    }

    private function getDescriptionInput()
    {
        return $this->createTextInput(
            'description',
            '描述',
            false,
            255
        );
    }

    private function getPermissionsSelect()
    {
        return $this->createRelationSelect(
            'permissions',
            '權限',
            'permissions',
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
            $this->getDescriptionColumn(),
            $this->getPermissionsColumn(),
        ];
    }

    private function getNameColumn()
    {
        return $this->createTextColumn(
            'name',
            '角色名稱',
            true,
            true
        );
    }

    private function getDescriptionColumn()
    {
        return $this->createTextColumn(
            'description',
            '描述'
        );
    }

    private function getPermissionsColumn()
    {
        return Tables\Columns\TextColumn::make('permissions.name')
            ->label('權限')
            ->badge();
    }

    public function getTableFilters(): array
    {
        return [];
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
