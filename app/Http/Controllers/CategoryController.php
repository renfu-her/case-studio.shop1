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
        $category = Category::findOrFail($id);
        
        // 獲取所有頂層分類
        $rootCategories = Category::where('parent_id', 0)->orWhereNull('parent_id')->get();
        
        // 獲取當前分類的所有子分類
        $subcategories = Category::where('parent_id', $id)->get();
        
        // 獲取當前分類及其所有子分類的ID
        $categoryIds = collect([$id]);
        $this->getAllSubcategoryIds($category, $categoryIds);
        
        // 獲取當前分類及其子分類下的所有產品
        $products = Product::whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->paginate(9);
        
        // 獲取當前分類的完整路徑
        $categoryPath = $this->getCategoryPath($category);
        
        return view('categories.show', compact('category', 'subcategories', 'products', 'rootCategories', 'categoryPath'));
    }

    /**
     * 遞迴獲取所有子分類ID
     */
    private function getAllSubcategoryIds($category, &$categoryIds)
    {
        $subcategories = Category::where('parent_id', $category->id)->get();
        
        foreach ($subcategories as $subcategory) {
            $categoryIds->push($subcategory->id);
            $this->getAllSubcategoryIds($subcategory, $categoryIds);
        }
    }

    /**
     * 獲取分類的完整路徑
     */
    private function getCategoryPath($category)
    {
        $path = collect([$category]);
        $currentCategory = $category;
        
        while ($currentCategory->parent_id != 0 && $currentCategory->parent_id !== null) {
            $parentCategory = Category::find($currentCategory->parent_id);
            if ($parentCategory) {
                $path->prepend($parentCategory);
                $currentCategory = $parentCategory;
            } else {
                break;
            }
        }
        
        return $path;
    }
}
