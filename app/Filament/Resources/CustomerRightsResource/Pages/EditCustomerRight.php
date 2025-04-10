<?php

namespace App\Filament\Resources\CustomerRightsResource\Pages;

use App\Filament\Resources\CustomerRightsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerRight extends EditRecord
{
    protected static string $resource = CustomerRightsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
} 