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
        $category = Category::where('is_active', true)->findOrFail($id);
        
        // 使用 Service 獲取所有頂層分類
        $rootCategories = $this->categoryService->getRootCategories();
        
        // 獲取當前分類的所有子分類
        $subcategories = Category::where('parent_id', $id)
            ->where('is_active', true)
            ->get();
        
        // 使用 Service 獲取當前分類及其所有子分類的ID
        $categoryIds = $this->categoryService->getCategoryAndChildrenIds($category);
        
        // 使用 ProductService 獲取商品
        $products = $this->productService->getByCategoryIds($categoryIds);
        
        // 使用 Service 獲取當前分類的完整路徑
        $categoryPath = $this->categoryService->getCategoryPath($category);

        dd($rootCategories, $categoryPath);
        
        return view('categories.show', compact('category', 'subcategories', 'products', 'rootCategories', 'categoryPath'));
    }
}
