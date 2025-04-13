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
        $subcategories = Category::where('parent_id', $id)->get();
        
        // 獲取該類別及其子類別的所有商品
        $categoryIds = [$id];
        foreach ($subcategories as $subcategory) {
            $categoryIds[] = $subcategory->id;
        }
        
        $products = Product::whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->paginate(9);
            
        return view('categories.show', compact('category', 'subcategories', 'products'));
    }
}
