<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use App\Services\BannerService;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = '網站管理';
    protected static ?string $navigationLabel = '廣告管理';
    protected static ?string $modelLabel = '廣告';
    protected static ?string $pluralModelLabel = '廣告';
    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form->schema(
            app(BannerService::class)->getFormSchema()
        );
    }

    public static function table(Table $table): Table
    {
        $service = app(BannerService::class);

        return $table
            ->columns($service->getTableColumns())
            ->filters($service->getTableFilters())
            ->actions($service->getTableActions())
            ->bulkActions($service->getTableBulkActions())
            ->defaultSort('sort', 'asc')
            ->paginated([10, 20, 30, 50, 100, 'all'])
            ->defaultPaginationPageOption(20);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}