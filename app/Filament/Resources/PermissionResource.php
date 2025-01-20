<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermissionResource\Pages;
use App\Models\Permission;
use App\Services\PermissionService;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $navigationGroup = '系統管理';
    protected static ?int $navigationGroupSort = 3;
    protected static ?string $navigationLabel = '權限';
    protected static ?string $modelLabel = '權限';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema(
            app(PermissionService::class)->getFormSchema()
        );
    }

    public static function table(Table $table): Table
    {
        $service = app(PermissionService::class);

        return $table
            ->columns($service->getTableColumns())
            ->filters($service->getTableFilters())
            ->actions($service->getTableActions())
            ->bulkActions($service->getTableBulkActions())
            ->emptyStateHeading('尚無權限');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }
}
