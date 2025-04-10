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
use Filament\Tables\Enums\RecordCheckboxPosition;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = '系統管理';
    protected static ?string $navigationLabel = '管理者';
    protected static ?string $modelLabel = '管理者';
    protected static ?string $pluralModelLabel = '管理者';
    protected static ?int $navigationSort = 1;

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
            ->bulkActions([])
            ->emptyStateHeading('尚無管理者')
            ->defaultSort('created_at', 'desc')
            ->paginated([10,20,30,50,100,'all'])
            ->defaultPaginationPageOption(20);
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
