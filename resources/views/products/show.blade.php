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
                    @if($category)
                    <li class="breadcrumb-item"><a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a></li>
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
                        <h4 class="product_title">{{ $product->name }}</h4>
                        <div class="product_price">
                            <span class="price">${{ number_format($product->price, 2) }}</span>
                            @if($product->original_price)
                            <del>${{ number_format($product->original_price, 2) }}</del>
                            <div class="on_sale">
                                <span>{{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}% Off</span>
                            </div>
                            @endif
                        </div>
                        <div class="rating_wrap">
                            <div class="rating">
                                <div class="product_rate" style="width:80%"></div>
                            </div>
                            <span class="rating_num">({{ rand(10, 50) }})</span>
                        </div>
                        @if($product->sub_title)
                        <div class="sub_title">
                            {!! $product->sub_title !!}
                        </div>
                        @endif
                        <div class="product_sort_info">
                            <ul>
                                <li><i class="fa-solid fa-check"></i> 庫存: <span class="text-success">有貨</span></li>
                                <li><i class="fa-solid fa-check"></i> 商品編號: <span>{{ $product->id }}</span></li>
                                <li><i class="fa-solid fa-check"></i> 類別: <span>{{ $category ? $category->name : '未分類' }}</span></li>
                            </ul>
                        </div>
                        <div class="pr_switch_wrap">
                            <span class="switch_lable">數量</span>
                            <div class="quantity">
                                <input type="number" class="form-control input-qty" value="1" min="1" max="10">
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
                <div class="related_slider carousel_slider owl-carousel owl-theme" data-margin="20" data-loop="true" data-autoplay="true" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                    @forelse($relatedProducts as $relatedProduct)
                    <div class="item">
                        <div class="product">
                            <div class="product_img">
                                <a href="{{ route('products.show', $relatedProduct->id) }}">
                                    <img src="{{ Storage::url($relatedProduct->image) }}" alt="{{ $relatedProduct->name }}">
                                </a>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title"><a href="{{ route('products.show', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a></h6>
                                <div class="product_price">
                                    <span class="price">${{ number_format($relatedProduct->price, 2) }}</span>
                                    @if($relatedProduct->original_price)
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

.sub_title {
    margin: 15px 0;
    font-size: 14pt;
}

.product_description {
    margin-top: 30px;
}

.heading_s1 {
    margin-bottom: 20px;
}

.img-fixed {
    width: 100%;
    height: auto;
    object-fit: contain;
}
</style>
@endpush 