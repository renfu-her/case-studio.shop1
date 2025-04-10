<?php

namespace App\Filament\Resources\ProductCategory;

use Filament\Resources\Resource;
use Filament\Resources\ResourceCollection;
use Filament\Resources\ResourceGroup;
 
class ProductCategoryResource
{
    public static function getDefaultPaginationPageSize(): int
    {
        return 20;
    }

    public static function getDefaultPaginationPageSizeOptions(): array
    {
        return [10, 20, 30, 50, 100, 'all'];
    }
}
 