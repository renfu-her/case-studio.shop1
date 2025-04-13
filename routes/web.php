<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;

Route::get('/', [HomeController::class, 'index'])->name('home'  );
Route::post('/subscribe', [HomeController::class, 'subscribe'])->name('subscribe');

Route::get('/captcha/generate', function () {
    $length = 6;
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $captcha = '';
    for ($i = 0; $i < $length; $i++) {
        $captcha .= $characters[rand(0, strlen($characters) - 1)];
    }

    session(['captcha' => $captcha]);

    $image = imagecreatetruecolor(120, 40);
    $bg = imagecolorallocate($image, 22, 28, 36);  // 深色背景
    $textColor = imagecolorallocate($image, 255, 255, 255);  // 白色文字

    // 填充背景
    imagefill($image, 0, 0, $bg);

    // 添加干擾點
    for ($i = 0; $i < 50; $i++) {
        $pointColor = imagecolorallocate($image, rand(50, 200), rand(50, 200), rand(50, 200));
        imagesetpixel($image, rand(0, 120), rand(0, 40), $pointColor);
    }

    // 添加干擾線
    for ($i = 0; $i < 3; $i++) {
        $lineColor = imagecolorallocate($image, rand(50, 200), rand(50, 200), rand(50, 200));
        imageline($image, rand(0, 120), rand(0, 40), rand(0, 120), rand(0, 40), $lineColor);
    }

    // 寫入驗證碼
    imagettftext($image, 20, 0, 15, 30, $textColor, public_path('fonts/Arial.ttf'), $captcha);

    ob_start();
    imagepng($image);
    $imageData = ob_get_clean();
    imagedestroy($image);

    return response($imageData)->header('Content-Type', 'image/png');
})->name('captcha.generate');

// 會員認證路由
Route::middleware('guest:member')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
});

// 會員專區路由
Route::prefix('member')->name('member.')->middleware('auth:member')->group(function () {
    Route::get('/', [MemberController::class, 'index'])->name('index');
    Route::get('/edit', [MemberController::class, 'edit'])->name('edit');
    Route::post('/update', [MemberController::class, 'update'])->name('update');
    Route::get('/orders', [MemberController::class, 'orders'])->name('orders');
    Route::get('/orders/{orderNumber}', [MemberController::class, 'orderDetail'])->name('order.detail');
    Route::get('/change-password', [MemberController::class, 'changePassword'])->name('change-password');
    Route::post('/update-password', [MemberController::class, 'updatePassword'])->name('update-password');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth:member');

Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
