<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    ProductController,
    CategoryController,
    BannerController,
    CouponController,
    EventController,
    FaqController,
    FaqCategoryController,
    OrderController,
    UserController,
    RoleController,
    PermissionController
};


Route::get('/products', [ProductController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);

// Banner routes
Route::get('/banners', [BannerController::class, 'index']);

// Coupon routes
Route::get('/coupons', [CouponController::class, 'index']);

// Event routes
Route::get('/events', [EventController::class, 'index']);

// FAQ routes
Route::get('/faqs', [FaqController::class, 'index']);
Route::get('/faq-categories', [FaqCategoryController::class, 'index']);

// Order routes
Route::get('/orders', [OrderController::class, 'index']);

// User routes
Route::get('/users', [UserController::class, 'index']);

// Role & Permission routes
Route::get('/roles', [RoleController::class, 'index']);
Route::get('/permissions', [PermissionController::class, 'index']);
