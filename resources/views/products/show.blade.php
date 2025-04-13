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
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fixed">
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
                        <div class="pr_desc">
                            <p>{{ $product->description }}</p>
                        </div>
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
                            <ul class="list_none pr_action_btn">
                                <li class="add-to-cart"><a href="#" class="btn btn-fill-out btn-addtocart"><i class="fa-solid fa-cart-shopping"></i> 加入購物車</a></li>
                                <li><a href="#" class="btn btn-fill-out btn-addtocart"><i class="fa-solid fa-heart"></i> 加入願望清單</a></li>
                                <li><a href="#" class="btn btn-fill-out btn-addtocart"><i class="fa-solid fa-arrows-rotate"></i> 加入比較</a></li>
                            </ul>
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
                                    <img src="{{ asset($relatedProduct->image) }}" alt="{{ $relatedProduct->name }}">
                                </a>
                                <div class="product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li class="add-to-cart"><a href="#"><i class="fa-solid fa-cart-shopping"></i> 加入購物車</a></li>
                                        <li><a href="#" class="popup-ajax"><i class="fa-solid fa-arrows-rotate"></i></a></li>
                                        <li><a href="#" class="popup-ajax"><i class="fa-solid fa-magnifying-glass"></i></a></li>
                                        <li><a href="#"><i class="fa-solid fa-heart"></i></a></li>
                                    </ul>
                                </div>
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