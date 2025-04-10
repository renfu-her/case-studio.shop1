<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FreeShippingResource\Pages;
use App\Models\FreeShipping;
use App\Services\FreeShippingService;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class FreeShippingResource extends Resource
{
    protected static ?string $model = FreeShipping::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = '網站管理';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = '免運費設定';

    public static function form(Form $form): Form
    {
        return $form->schema(
            app(FreeShippingService::class)->getFormSchema()
        );
    }

    public static function table(Table $table): Table
    {
        $service = app(FreeShippingService::class);

        return $table
            ->columns($service->getTableColumns())
            ->filters($service->getTableFilters())
            ->actions($service->getTableActions())
            ->bulkActions($service->getTableBulkActions())
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
            'index' => Pages\ListFreeShippings::route('/'),
            'create' => Pages\CreateFreeShipping::route('/create'),
            'edit' => Pages\EditFreeShipping::route('/{record}/edit'),
        ];
    }

}
