<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use App\Services\EventService;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = '網站管理';
    protected static ?string $navigationLabel = '活動訊息';
    protected static ?string $modelLabel = '活動訊息';
    protected static ?string $pluralModelLabel = '活動訊息';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema(
            app(EventService::class)->getFormSchema()
        );
    }

    public static function table(Table $table): Table
    {
        $service = app(EventService::class);

        return $table
            ->columns($service->getTableColumns())
            ->filters($service->getTableFilters())
            ->actions($service->getTableActions())
            ->bulkActions($service->getTableBulkActions())
            ->defaultSort('sort', 'asc')
            ->paginated([10,20,30,50,100,'all'])
            ->defaultPaginationPageOption(20);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }

}
