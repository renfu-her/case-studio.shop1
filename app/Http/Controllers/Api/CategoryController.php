<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::select([
                'id',
                'name',
                // 'is_active',
                'parent_id'
            ])
            ->withCount('products')
            ->where('is_active', true)
            ->where('parent_id', null)  // 只获取顶级分类
            ->orderBy('sort')
            ->with(['children' => function ($query) {
                $query->select([
                    'id',
                    'name',
                    // 'is_active',
                    'parent_id'
                ])
                ->where('is_active', true)
                ->withCount('products')
                ->orderBy('sort');
            }])
            ->get();

        return response()->json($categories);
    }
}
