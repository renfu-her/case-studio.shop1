<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class MemberController extends Controller
{
    /**
     * 建構子
     */
    public function __construct()
    {
        $this->middleware('auth:member');
    }

    /**
     * 會員中心首頁
     */
    public function index()
    {
        $user = Auth::guard('member')->user();
        $orders = Order::where('user_id', $user->id)
                      ->latest()
                      ->take(5)
                      ->get();

        return view('member.index', compact('user', 'orders'));
    }

    /**
     * 會員資料編輯頁面
     */
    public function edit()
    {
        $user = Auth::guard('member')->user();
        return view('member.edit', compact('user'));
    }

    /**
     * 更新會員資料
     */
    public function update(Request $request)
    {
        $user = Auth::guard('member')->user();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'address']));

        return redirect()->route('member.edit')
            ->with('success', '會員資料已更新成功！');
    }

    /**
     * 訂單列表
     */
    public function orders()
    {
        $orders = Order::where('user_id', Auth::guard('member')->id())
                      ->latest()
                      ->paginate(10);

        return view('member.orders', compact('orders'));
    }

    /**
     * 訂單詳情
     */
    public function orderDetail($orderNumber)
    {
        $order = Order::where('user_id', Auth::guard('member')->id())
                     ->where('order_number', $orderNumber)
                     ->firstOrFail();

        return view('member.order-detail', compact('order'));
    }

    /**
     * 修改密碼頁面
     */
    public function changePassword()
    {
        return view('member.change-password');
    }

    /**
     * 更新密碼
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Auth::guard('member')->user()->update([
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('member.change-password')
            ->with('success', '密碼已更新成功！');
    }
} 