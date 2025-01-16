<?php

namespace App\Filament\Resources\FreeShippingResource\Pages;

use App\Filament\Resources\FreeShippingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFreeShipping extends EditRecord
{
    protected static string $resource = FreeShippingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
