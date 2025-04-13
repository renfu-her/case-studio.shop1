<?php

namespace App\Services\Api;

use App\Services\Service;
use App\Models\Category;

class CategoryService extends Service
{
    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 獲取分層結構的分類列表
     */
    public function index()
    {
        // 獲取所有啟用的分類
        $categories = Category::where('is_active', true)
            ->orderBy('sort')
            ->get();

        // 構建分層結構
        $tree = $this->buildCategoryTree($categories);

        return $tree;
    }

    /**
     * 遞迴構建分類樹狀結構
     */
    private function buildCategoryTree($categories, $parentId = null)
    {
        $result = [];

        foreach ($categories as $category) {
            if ($category->parent_id === $parentId) {
                $children = $this->buildCategoryTree($categories, $category->id);

                $categoryData = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'sort' => $category->sort,
                ];

                // 只有當有子分類時才添加 children 欄位
                if (!empty($children)) {
                    $categoryData['children'] = $children;
                }

                $result[] = $categoryData;
            }
        }

        // 按照 sort 排序
        usort($result, function ($a, $b) {
            return $a['sort'] <=> $b['sort'];
        });

        return $result;
    }

    /**
     * 獲取根分類列表
     */
    public function getRootCategories()
    {
        return Category::where('is_active', true)
            ->where(function($query) {
                $query->where('parent_id', 0)
                      ->orWhereNull('parent_id');
            })
            ->orderBy('sort')
            ->get();
    }

    /**
     * 獲取分類及其所有子分類的ID
     */
    public function getCategoryAndChildrenIds($category)
    {
        $categoryIds = collect([$category->id]);
        $this->getAllSubcategoryIds($category, $categoryIds);
        return $categoryIds;
    }

    /**
     * 遞迴獲取所有子分類ID
     */
    private function getAllSubcategoryIds($category, &$categoryIds)
    {
        $subcategories = Category::where('parent_id', $category->id)
            ->where('is_active', true)
            ->get();
        
        foreach ($subcategories as $subcategory) {
            $categoryIds->push($subcategory->id);
            $this->getAllSubcategoryIds($subcategory, $categoryIds);
        }
    }

    /**
     * 獲取分類的完整路徑
     */
    public function getCategoryPath($category)
    {
        $path = collect([$category]);
        $currentCategory = $category;
        
        while ($currentCategory->parent_id != 0 && $currentCategory->parent_id !== null) {
            $parentCategory = Category::where('is_active', true)
                ->find($currentCategory->parent_id);
            
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
