<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return '';
});

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
    imagettftext($image, 20, 0, 15, 30, $textColor, public_path('fonts/arial.ttf'), $captcha);

    ob_start();
    imagepng($image);
    $imageData = ob_get_clean();
    imagedestroy($image);

    return response($imageData)->header('Content-Type', 'image/png');
})->name('captcha.generate');
