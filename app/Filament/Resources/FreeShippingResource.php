<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FreeShippingResource\Pages;
use App\Models\FreeShipping;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FreeShippingResource extends Resource
{
    protected static ?string $model = FreeShipping::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = '設定';

    protected static ?string $modelLabel = '免運費設定';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('min_amount')
                    ->label('最低訂單金額')
                    ->required()
                    ->numeric()
                    ->minValue(0),

                Forms\Components\DateTimePicker::make('start_at')
                    ->label('開始時間'),

                Forms\Components\DateTimePicker::make('end_at')
                    ->label('結束時間')
                    ->after('start_at'),

                Forms\Components\Toggle::make('is_active')
                    ->label('啟用')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('min_amount')
                    ->label('最低訂單金額')
                    ->money('TWD'),

                Tables\Columns\TextColumn::make('start_at')
                    ->label('開始時間')
                    ->dateTime(),

                Tables\Columns\TextColumn::make('end_at')
                    ->label('結束時間')
                    ->dateTime(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('啟用狀態')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('建立時間')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')
                    ->label('僅顯示啟用')
                    ->query(fn($query) => $query->where('is_active', true)),
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
