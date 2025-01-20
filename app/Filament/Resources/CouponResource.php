<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Models\Coupon;
use App\Services\CouponService;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = '銷售管理';
    protected static ?string $navigationLabel = '折價券';
    protected static ?string $modelLabel = '折價券';
    protected static ?string $pluralModelLabel = '折價券';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema(
            app(CouponService::class)->getFormSchema()
        );
    }

    public static function table(Table $table): Table
    {
        $service = app(CouponService::class);

        return $table
            ->columns($service->getTableColumns())
            ->filters($service->getTableFilters())
            ->actions($service->getTableActions())
            ->bulkActions($service->getTableBulkActions())
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
