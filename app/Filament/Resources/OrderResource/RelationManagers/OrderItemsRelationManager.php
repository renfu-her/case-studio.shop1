<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\OrderItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = '訂單商品';

    protected static ?string $modelLabel = '訂單商品';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->label('商品')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state) {
                            $product = \App\Models\Product::find($state);
                            $set('unit_price', $product->price);
                            $quantity = 1;
                            $set('quantity', $quantity);
                            $set('total_price', $product->price * $quantity);
                        }
                    }),
                Forms\Components\TextInput::make('quantity')
                    ->label('數量')
                    ->numeric()
                    ->default(1)
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, $get, Forms\Set $set) {
                        $quantity = $state ?? 1;
                        $unitPrice = $get('unit_price') ?? 0;
                        $set('total_price', $unitPrice * $quantity);
                    }),
                Forms\Components\TextInput::make('unit_price')
                    ->label('單價')
                    ->numeric()
                    ->required()
                    ->readOnly()
                    ->dehydrated(),
                Forms\Components\TextInput::make('total_price')
                    ->label('總價')
                    ->numeric()
                    ->readOnly()
                    ->dehydrated(),
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['product_id'])) {
            $product = \App\Models\Product::find($data['product_id']);
            $data['unit_price'] = $product->price;
            $data['total_price'] = $data['unit_price'] * $data['quantity'];
        }
        return $data;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('商品')
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('數量')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit_price')
                    ->label('單價')
                    ->money('TWD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('總價')
                    ->money('TWD')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
