<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\JsonResponse;

class FaqCategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = FaqCategory::with('faqs')
            ->where('is_active', true)
            ->orderBy('sort')
            ->get();

        return response()->json($categories);
    }
} 