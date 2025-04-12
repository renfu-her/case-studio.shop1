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
        $featuredProducts = Product::where('is_active', 1)
            ->take(4)
            ->get();
            
        // 獲取熱門分類
        $featuredCategories = Category::where('is_active',1)
            ->where('parent_id', 0)
            ->get();
            
        // 獲取橫幅廣告
        $banners = Banner::where('is_active',1)
            ->get();
            
        return view('home', compact('featuredProducts', 'featuredCategories', 'banners'));
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