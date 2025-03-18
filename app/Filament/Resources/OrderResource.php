<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = '銷售管理';

    protected static ?int $navigationSort  = 2;

    protected static ?string $modelLabel = '訂單';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_id')
                    ->label('訂單編號')
                    ->default(fn() => Order::generateOrderId())
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\Select::make('user_id')
                    ->label('會員')
                    ->relationship('member', 'name')
                    ->required(),
                Forms\Components\TextInput::make('total_amount')
                    ->label('訂單金額')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('訂單狀態')
                    ->options([
                        'pending' => '待付款',
                        'processing' => '處理中',
                        'shipped' => '已出貨',
                        'delivered' => '已送達',
                        'cancelled' => '已取消',
                    ])
                    ->required(),
                Forms\Components\Select::make('payment_method')
                    ->label('付款方式')
                    ->options([
                        'credit_card' => '信用卡',
                        'bank_transfer' => '銀行轉帳',
                        'convenience_store' => '超商付款',
                        'line_pay' => 'Line Pay',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('shipping_address')
                    ->label('貨運收件地址')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('billing_address')
                    ->label('付款收件地址')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('tracking_number')
                    ->label('追蹤號碼'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_id')
                    ->label('訂單編號')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('會員')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('訂單金額')
                    ->money('TWD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('訂單狀態')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'processing' => 'info',
                        'shipped' => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => '待付款',
                        'processing' => '處理中',
                        'shipped' => '已出貨',
                        'delivered' => '已送達',
                        'cancelled' => '已取消',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('付款方式')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'credit_card' => '信用卡',
                        'bank_transfer' => '銀行轉帳',
                        'convenience_store' => '超商付款',
                        'line_pay' => 'Line Pay',
                        default => $state,
                    })
                    ->badge(),
                Tables\Columns\TextColumn::make('tracking_number')
                    ->label('追蹤號碼')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('建立時間')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => '待付款',
                        'processing' => '處理中',
                        'shipped' => '已出貨',
                        'delivered' => '已送達',
                        'cancelled' => '已取消',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OrderItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
