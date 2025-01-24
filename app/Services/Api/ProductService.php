<?php

namespace App\Services\Api;

use App\Services\Service;
use App\Models\Product;

class ProductService extends Service
{

    public function __construct()
    {
        //
    }

    public function index()
    {
        $products = Product::with('category')->get();

        return $products;
    }
} 