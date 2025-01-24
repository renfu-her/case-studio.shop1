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
}
