<?php

namespace App\Filament\Resources\FreeShippingResource\Pages;

use App\Filament\Resources\FreeShippingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;

class ListFreeShippings extends ListRecords
{
    protected static string $resource = FreeShippingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('min_amount')
                ->label('最低訂單金額')
                ->money('TWD'),

            TextColumn::make('start_at')
                ->label('開始時間')
                ->dateTime('Y-m-d H:i'),

            TextColumn::make('end_at')
                ->label('結束時間')
                ->dateTime('Y-m-d H:i'),

            TextColumn::make('is_active')
                ->label('啟用狀態')
                ->boolean(),

            TextColumn::make('created_at')
                ->label('建立時間')
                ->dateTime('Y-m-d H:i')
                ->sortable(),
        ];
    }
}
