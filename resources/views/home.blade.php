@extends('layouts.app')

@section('title', '首頁 - ' . config('app.name'))

@section('content')
<!-- START SECTION BANNER -->
<div class="banner_section slide_medium shop_banner_slider staggered-animation-wrap">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="banner_slider carousel_slider owl-carousel owl-theme nav_style1" data-loop="true" data-dots="false" data-nav="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "767":{"items": "1"}, "991":{"items": "1"}, "1199":{"items": "1"}}'>
                    @foreach($sliderBanners as $banner)
                    <div class="item">
                        <div class="banner_slide_content banner_content_inner">
                            <div class="col-lg-7 col-10">
                                <div class="banner_content overflow-hidden">
                                    @if($banner->title)
                                    <h5 class="mb-3 staggered-animation" data-animation="slideInLeft" data-animation-delay="0.5s">{{ $banner->title }}</h5>
                                    @endif
                                    <a class="btn btn-fill-out rounded-0 staggered-animation text-uppercase" href="{{ $banner->link }}" data-animation="slideInLeft" data-animation-delay="1s">立即購買</a>
                                </div>
                            </div>
                        </div>
                        <img src="{{ asset('storage/' . $banner->image) }}" alt="slider_banner"/>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION BANNER -->

<!-- START SECTION FEATURES -->
<section class="section small_pt">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="icon_box icon_box_style1">
                    <div class="icon">
                        <i class="linearicons-truck"></i>
                    </div>
                    <div class="icon_box_content">
                        <h5>免費運送</h5>
                        <p>訂單滿 $1000 免運費</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="icon_box icon_box_style1">
                    <div class="icon">
                        <i class="linearicons-credit-card"></i>
                    </div>
                    <div class="icon_box_content">
                        <h5>安全付款</h5>
                        <p>100% 安全支付</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="icon_box icon_box_style1">
                    <div class="icon">
                        <i class="linearicons-rotate-left"></i>
                    </div>
                    <div class="icon_box_content">
                        <h5>輕鬆退換</h5>
                        <p>30 天無條件退換</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="icon_box icon_box_style1">
                    <div class="icon">
                        <i class="linearicons-headset"></i>
                    </div>
                    <div class="icon_box_content">
                        <h5>24/7 支援</h5>
                        <p>全天候客戶服務</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END SECTION FEATURES -->

<!-- START SECTION CATEGORIES -->
<div class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="heading_s1">
                    <h2>熱門分類</h2>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            @foreach($featuredCategories as $category)
            <div class="col-lg-4 col-md-6">
                <div class="categories_box">
                    <a href="#">
                        <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('assets/images/no-image.svg') }}" alt="cat_img1"/>
                        <span>{{ $category->name }}</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- END SECTION CATEGORIES -->

<!-- START SECTION SHOP -->
<div class="section small_pt pb_70">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="heading_s1">
                    <h2>熱門商品</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($featuredProducts as $product)
            <div class="col-lg-3 col-md-4 col-6">
                <div class="product">
                    <div class="product_img">
                        <a href="#">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/images/no-image.svg') }}" alt="product_img1"/>
                        </a>
                        <div class="product_action_box">
                            <ul class="list_none pr_action_btn">
                                <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> 加入購物車</a></li>
                                <li><a href="#" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                <li><a href="#"><i class="icon-heart"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="product_info">
                        <h6 class="product_title"><a href="#">{{ $product->name }}</a></h6>
                        <div class="product_price">
                            <span class="price">${{ number_format($product->price, 2) }}</span>
                        </div>
                        <div class="rating_wrap">
                            <div class="rating">
                                <div class="product_rate" style="width:80%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- END SECTION SHOP -->

<!-- START SECTION NEWSLETTER -->
<section class="section bg_light_blue2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="newsletter_wrap">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="heading_s1">
                                <h3>訂閱我們的電子報</h3>
                                <p>訂閱電子報以獲取最新優惠和產品資訊</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('subscribe') }}" method="post">
                                @csrf
                                <div class="newsletter_form">
                                    <input type="text" name="email" class="form-control" placeholder="輸入您的電子郵件">
                                    <button type="submit" class="btn btn-fill-out">訂閱</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END SECTION NEWSLETTER -->

@push('scripts')
<script>
$(document).ready(function() {
    $('.banner_slider.carousel_slider').each(function() {
        var $carousel = $(this);
        $carousel.owlCarousel({
            dots: $carousel.data("dots"),
            loop: $carousel.data("loop"),
            margin: $carousel.data("margin"),
            nav: $carousel.data("nav"),
            responsive: {
                0: {
                    items: 1
                },
                767: {
                    items: 1
                },
                991: {
                    items: 1
                },
                1199: {
                    items: 1
                }
            }
        });
    });
});
</script>
@endpush
@endsection 