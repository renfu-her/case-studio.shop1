@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <!-- START SECTION BREADCRUMB -->
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>{{ $product->name }}</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">首頁</a></li>
                        <li class="breadcrumb-item"><a href="#">商品專區</a></li>
                        @if ($category)
                            <li class="breadcrumb-item"><a
                                    href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a></li>
                        @endif
                        <li class="breadcrumb-item active">{{ $product->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION BREADCRUMB -->

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 mb-4 mb-lg-0">
                    <div class="product_image">
                        <div class="product_img">
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="img-fixed">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="pr_detail">
                        <div class="product_description">
                            <h1 class="product_title">
                                {{ $product->name }}
                            </h1>
                            <div class="rating_wrap d-flex align-items-center mb-3">
                                <div class="rating me-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star text-warning"></i>
                                    @endfor
                                </div>
                                <span class="rating_num">5.0</span>
                                <a href="#reviews" class="rating_link ms-2">({{ rand(1, 5) }} 則評價)</a>
                            </div>
                            <div class="product_price_wrap bg-light p-3 rounded mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="special_price">
                                        <span
                                            class="current_price text-danger fs-3 fw-bold">${{ number_format($product->price, 0) }}</span>
                                        @if ($product->original_price)
                                            <del
                                                class="old_price ms-2 text-muted">${{ number_format($product->original_price, 0) }}</del>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if ($product->specs->count() > 0)
                                <div class="product_specs mb-4">
                                    <div class="form-group">
                                        <label for="product_spec" class="form-label">規格</label>
                                        <select class="form-select" id="product_spec" name="spec_id">
                                            <option value="">請選擇規格</option>
                                            @foreach ($product->specs as $spec)
                                                <option value="{{ $spec->id }}" data-price="{{ $spec->price }}">
                                                    {{ $spec->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            @if ($product->sub_title)
                                <div class="sub_title mb-3">
                                    {!! $product->sub_title !!}
                                </div>
                            @endif
                            <div class="product_sort_info mb-4">
                                <ul>
                                    <li><i class="fa-solid fa-check"></i> 庫存: <span class="text-success">有貨</span></li>
                                    <li><i class="fa-solid fa-check"></i> 商品編號: <span>{{ $product->id }}</span></li>
                                    <li><i class="fa-solid fa-check"></i> 類別:
                                        <span>{{ $category ? $category->name : '未分類' }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="pr_switch_wrap">
                                <span class="switch_lable">數量</span>
                                <div class="quantity">
                                    <select class="form-select" id="product_quantity" name="quantity">
                                        @for ($i = 1; $i <= 20; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="product_action">
                                <div class="d-flex gap-3 align-items-center">
                                    <button type="button" class="btn btn-outline-danger d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-heart"></i>
                                        <span>追蹤</span>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary flex-grow-1">加入購物車</button>
                                    <button type="button" class="btn btn-danger flex-grow-1">立即購買</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="small_divider"></div>
                    <div class="divider"></div>
                    <div class="medium_divider"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="heading_s1">
                        <h3>商品詳情</h3>
                    </div>
                    <div class="product_description">
                        {!! $product->description !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="heading_s1">
                        <h3>相關商品</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="related_slider carousel_slider owl-carousel owl-theme" data-margin="20" data-loop="true"
                        data-autoplay="true"
                        data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                        @forelse($relatedProducts as $relatedProduct)
                            <div class="item">
                                <div class="product">
                                    <div class="product_img">
                                        <a href="{{ route('products.show', $relatedProduct->id) }}">
                                            <img src="{{ Storage::url($relatedProduct->image) }}"
                                                alt="{{ $relatedProduct->name }}">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a
                                                href="{{ route('products.show', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a>
                                        </h6>
                                        <div class="product_price">
                                            <span class="price">${{ number_format($relatedProduct->price, 2) }}</span>
                                            @if ($relatedProduct->original_price)
                                                <del>${{ number_format($relatedProduct->original_price, 2) }}</del>
                                            @endif
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:80%"></div>
                                            </div>
                                            <span class="rating_num">({{ rand(10, 50) }})</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">
                                    目前沒有相關商品。
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->
@endsection

@push('styles')
    <style>
        .product_action {
            margin-top: 20px;
        }

        .product_action .btn {
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 16px;
        }

        .product_action .btn-outline-danger {
            min-width: 100px;
        }

        .product_action .btn-outline-primary,
        .product_action .btn-danger {
            min-width: 150px;
        }

        .gap-3 {
            gap: 1rem !important;
        }

        .d-flex {
            display: flex !important;
        }

        .align-items-center {
            align-items: center !important;
        }

        .flex-grow-1 {
            flex-grow: 1 !important;
        }

        .product_action .pr_action_btn {
            display: flex;
            gap: 10px;
        }

        .product_action .pr_action_btn li a {
            width: 40px;
            height: 40px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product_action .pr_action_btn li a i {
            margin: 0;
        }

        .product_title {
            margin-bottom: 1rem;
        }

        .product_price {
            margin-bottom: 0.5rem;
        }

        .rating_wrap {
            margin-bottom: 1rem;
        }

        .sub_title {
            margin-bottom: 1rem;
            font-size: 14pt;
        }

        .product_sort_info {
            margin-bottom: 1.5rem;
        }

        .product_sort_info ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .product_sort_info ul li {
            margin-bottom: 0.5rem;
        }

        .product_sort_info ul li:last-child {
            margin-bottom: 0;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .img-fixed {
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        .promotion_text {
            font-size: 1.2rem;
            color: #ff0000;
        }

        .product_title {
            font-size: 1.5rem;
            line-height: 1.4;
            margin-bottom: 1rem;
        }

        .rating_wrap {
            font-size: 1.1rem;
        }

        .rating_wrap .fa-star {
            color: #ffc107;
        }

        .rating_num {
            font-weight: bold;
            margin-right: 0.5rem;
        }

        .rating_link {
            color: #666;
            text-decoration: none;
        }

        .rating_link:hover {
            text-decoration: underline;
        }

        .product_price_wrap {
            background-color: #f8f9fa;
        }

        .current_price {
            font-size: 2rem;
            color: #ff0000;
        }

        .old_price {
            font-size: 1.2rem;
            text-decoration: line-through;
            color: #6c757d;
        }

        .special_price {
            display: flex;
            align-items: center;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        .rounded {
            border-radius: 0.375rem !important;
        }

        .p-3 {
            padding: 1rem !important;
        }

        .ms-2 {
            margin-left: 0.5rem !important;
        }

        .me-2 {
            margin-right: 0.5rem !important;
        }

        .fs-3 {
            font-size: 1.75rem !important;
        }

        .fw-bold {
            font-weight: bold !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .text-primary {
            color: #0d6efd !important;
        }

        .product_specs {
            margin-bottom: 1.5rem;
        }

        .product_specs .form-label {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .product_specs .form-select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .product_specs .form-select:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
        }

        .pr_switch_wrap {
            margin-bottom: 1.5rem;
        }

        .switch_lable {
            display: block;
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .quantity .form-select {
            width: 100px;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .quantity .form-select:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const specSelect = document.getElementById('product_spec');
            const priceElement = document.querySelector('.current_price');

            if (specSelect) {
                specSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    if (selectedOption.value) {
                        const price = selectedOption.dataset.price;
                        if (price) {
                            priceElement.textContent = '$' + Number(price).toLocaleString();
                        }
                    }
                });
            }
        });
    </script>
@endpush
