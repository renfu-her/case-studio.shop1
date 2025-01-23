<?php
namespace App\Filament\Resources\FaqCategoryResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\FaqCategoryResource;
use Illuminate\Routing\Router;


class FaqCategoryApiService extends ApiService
{
    protected static string | null $resource = FaqCategoryResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}
