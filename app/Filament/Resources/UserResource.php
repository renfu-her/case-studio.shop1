<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Services\UserService;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = '系統管理';
    protected static ?string $navigationLabel = '使用者';
    protected static ?string $modelLabel = '使用者';
    protected static ?string $pluralModelLabel = '使用者';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema(
            app(UserService::class)->getFormSchema()
        );
    }

    public static function table(Table $table): Table
    {
        $service = app(UserService::class);

        return $table
            ->columns($service->getTableColumns())
            ->filters($service->getTableFilters())
            ->actions([
                ...$service->getTableActions(),
            ])
            ->bulkActions([
                ...$service->getTableBulkActions(),
            ])
            ->emptyStateHeading('尚無使用者');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
