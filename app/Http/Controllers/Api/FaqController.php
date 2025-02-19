<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;

class FaqController extends Controller
{
    public function index(): JsonResponse
    {
        $faqs = Faq::with('category')
            ->where('is_active', true)
            ->orderBy('sort')
            ->get();

        return response()->json($faqs);
    }
} 