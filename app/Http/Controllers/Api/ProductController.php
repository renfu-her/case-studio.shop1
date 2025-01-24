<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Api\ProductService as Service;

class ProductController extends Controller
{

    protected $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $products = $this->service->index();

        return response()->json($products);
    }
}
