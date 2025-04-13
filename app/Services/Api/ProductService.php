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

    /**
     * 獲取所有啟用的商品
     */
    public function index()
    {
        return Product::with('category')
            ->where('is_active', true)
            ->get();
    }

    /**
     * 獲取指定分類ID列表下的商品
     */
    public function getByCategoryIds($categoryIds, $perPage = 9)
    {
        return Product::whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->paginate($perPage);
    }
} 