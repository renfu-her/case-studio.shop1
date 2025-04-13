<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\Api\CategoryService;
use App\Services\Api\ProductService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;
    protected $productService;

    public function __construct(CategoryService $categoryService, ProductService $productService)
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }

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
            ->with('children')
            ->findOrFail($id);
        
        // 獲取所有頂層分類
        $rootCategories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('sort')
            ->get();
        
        // 獲取當前分類的所有子分類
        $subcategories = $category->children;
        
        // 獲取當前分類及其所有子分類的ID
        $categoryIds = $category->descendants()
            ->where('is_active', true)
            ->pluck('id')
            ->push($category->id);
        
        // 獲取當前分類及其子分類下的所有產品
        $products = Product::whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->paginate(9);
        
        // 獲取當前分類的完整路徑
        $categoryPath = $category->ancestorsAndSelf()
            ->where('is_active', true)
            ->get();
        
        return view('categories.show', compact(
            'category',
            'subcategories',
            'products',
            'rootCategories',
            'categoryPath'
        ));
    }
}
