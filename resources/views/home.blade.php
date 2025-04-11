@extends('layouts.app')

@section('title', '首頁 - ' . config('app.name'))

@section('content')
<!-- START SECTION BANNER -->
<section class="home_banner_section">
    <div class="banner_section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="banner_content">
                        <h1 class="animation" data-animation="fadeInUp" data-delay="0.2s">時尚新品上市</h1>
                        <p class="animation" data-animation="fadeInUp" data-delay="0.4s">精選最新時尚單品，為您的衣櫃增添新風采</p>
                        <div class="btn_group animation" data-animation="fadeInUp" data-delay="0.6s">
                            <a class="btn btn-default btn-radius" href="#">立即購買</a>
                            <a class="btn btn-border btn-radius" href="#">了解更多</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="banner_image">
                        <img class="animation" data-animation="zoomIn" data-delay="0.4s" src="{{ asset('assets/images/banner_img1.png') }}" alt="banner_img1">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="heading_s1">
                    <h2>熱門分類</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($featuredCategories as $category)
            <div class="col-lg-4 col-md-6">
                <div class="categories_box">
                    <a href="#">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                        <span>{{ $category->name }}</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- END SECTION CATEGORIES -->

<!-- START SECTION PRODUCTS -->
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="heading_s1">
                    <h2>熱門商品</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($featuredProducts as $product)
            <div class="col-lg-3 col-md-4 col-6">
                <div class="product_box">
                    <div class="product_img">
                        <a href="#">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        </a>
                        <div class="product_action_box">
                            <ul class="list_none pr_action_btn">
                                <li><a href="#" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                <li><a href="#"><i class="icon-heart"></i></a></li>
                                <li><a href="#"><i class="icon-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="product_info">
                        <h6 class="product_title"><a href="#">{{ $product->name }}</a></h6>
                        <div class="product_price">
                            <span class="price">${{ number_format($product->price, 2) }}</span>
                            @if($product->original_price > $product->price)
                            <del>${{ number_format($product->original_price, 2) }}</del>
                            <div class="on_sale">
                                <span>{{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}% 折扣</span>
                            </div>
                            @endif
                        </div>
                        <div class="rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $product->rating)
                                    <i class="ion-ios-star"></i>
                                @elseif($i - 0.5 <= $product->rating)
                                    <i class="ion-ios-star-half"></i>
                                @else
                                    <i class="ion-ios-star-outline"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- END SECTION PRODUCTS -->

<!-- START SECTION BANNER -->
<section class="section">
    <div class="container">
        <div class="row">
            @foreach($banners as $banner)
            <div class="col-md-6">
                <div class="banner_img">
                    <a href="{{ $banner->link }}"><img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}"></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- END SECTION BANNER -->

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
@endsection 