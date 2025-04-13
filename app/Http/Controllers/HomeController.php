<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;

class HomeController extends Controller
{
    /**
     * 顯示首頁
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 獲取熱門商品
        $featuredProducts = Product::where('is_active', true)
            ->where('is_hot', true)  // 改用 is_hot 作為熱門商品的標誌
            ->with(['category', 'images'])  // 預加載關聯
            ->take(4)
            ->get();
            
        // 獲取熱門分類（只取頂層分類）
        $featuredCategories = Category::where('is_active', true)
            ->where(function($query) {
                $query->whereNull('parent_id')
                      ->orWhere('parent_id', 0);
            })
            ->with(['children' => function($query) {
                $query->where('is_active', true)
                      ->orderBy('sort');
            }])  // 預加載子分類
            ->orderBy('sort')  // 根據排序順序
            ->take(3)
            ->get();
            
        // 獲取輪播圖 Banner
        $sliderBanners = Banner::where('is_active', true)
            ->where('type', 'slider')  // 輪播圖類型
            ->orderBy('sort')
            ->get();
            
        return view('home', compact('featuredProducts', 'featuredCategories', 'sliderBanners'));
    }
    
    /**
     * 處理電子報訂閱
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email',
        ]);
        
        // 這裡可以添加訂閱邏輯，例如將電子郵件保存到資料庫
        
        return redirect()->back()->with('success', '感謝您訂閱我們的電子報！');
    }
} 