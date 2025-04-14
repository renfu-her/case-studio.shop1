<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * 顯示特定類別的商品
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // 獲取當前分類
        $category = Category::where('is_active', true)
            ->findOrFail($id);

        // 獲取所有頂層分類
        $rootCategories = Category::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', 0);
            })
            ->orderBy('sort')
            ->get();

        // 獲取當前分類的所有子分類
        $subcategories = Category::where('is_active', true)
            ->where('parent_id', $id)
            ->orderBy('sort')
            ->get();

        // 獲取當前分類及其子分類的所有商品
        $products = Product::where('is_active', true)
            ->where(function ($query) use ($id, $subcategories) {
                $query->where('category_id', $id)
                    ->orWhereIn('category_id', $subcategories->pluck('id'));
            })
            ->paginate(9);

        // 獲取當前分類的完整路徑
        $categoryPath = collect();
        $currentCategory = $category;

        while ($currentCategory) {
            $categoryPath->prepend($currentCategory);
            $currentCategory = Category::where('is_active', true)
                ->where('id', $currentCategory->parent_id)
                ->first();
        }

        return view('categories.show', compact(
            'category',
            'subcategories',
            'products',
            'rootCategories',
            'categoryPath'
        ));
    }
}