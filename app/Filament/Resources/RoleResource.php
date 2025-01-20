<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Models\Role;
use App\Services\RoleService;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = '系統管理';
    protected static ?string $navigationLabel = '角色管理';
    protected static ?string $modelLabel = '角色';
    protected static ?string $pluralModelLabel = '角色';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema(
            app(RoleService::class)->getFormSchema()
        );
    }

    public static function table(Table $table): Table
    {
        $service = app(RoleService::class);

        return $table
            ->columns($service->getTableColumns())
            ->filters($service->getTableFilters())
            ->actions($service->getTableActions())
            ->bulkActions($service->getTableBulkActions())
            ->emptyStateHeading('尚無角色')
            ->emptyStateDescription('建立角色來管理使用者權限')
            ->defaultSort('created_at', 'desc')
            ->searchPlaceholder('搜尋角色')
            ->filtersTriggerAction(
                fn($action) => $action
                    ->label('篩選')
            );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
