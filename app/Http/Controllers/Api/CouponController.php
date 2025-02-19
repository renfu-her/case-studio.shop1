<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\JsonResponse;

class CouponController extends Controller
{
    public function index(): JsonResponse
    {
        $coupons = Coupon::where('is_active', true)
            ->whereDate('start_at', '<=', now())
            ->whereDate('end_at', '>=', now())
            ->get();

        return response()->json($coupons);
    }
} 