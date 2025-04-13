@extends('layouts.app')

@section('title', '首頁 - ' . config('app.name'))

@section('content')
<!-- START SECTION BANNER -->
<div class="banner_section slide_medium shop_banner_slider staggered-animation-wrap">
    <div class="container-fluid px-0">
        <div class="row g-0">
            <div class="col-12">
                <div id="mainBanner" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach($sliderBanners as $key => $banner)
                        <button type="button" data-bs-target="#mainBanner" data-bs-slide-to="{{ $key }}" @if($loop->first) class="active" aria-current="true" @endif aria-label="Slide {{ $key + 1 }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach($sliderBanners as $key => $banner)
                        <div class="carousel-item @if($loop->first) active @endif banner-item">
                            <img src="{{ Storage::url($banner->image) }}" class="banner-img" alt="{{ $banner->title }}">
                            @if($banner->title)
                            <div class="carousel-caption d-flex align-items-end justify-content-center pb-4">
                                <div class="banner_content text-center w-100">
                                    <div class="banner_title_wrap">
                                        <h5 class="mb-0 text-white animate__animated animate__fadeInUp">{{ $banner->title }}</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#mainBanner" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">上一張</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#mainBanner" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">下一張</span>
                    </button>
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
                        <i class="fa-solid fa-truck"></i>
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
                        <i class="fa-solid fa-credit-card"></i>
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
                        <i class="fa-solid fa-rotate-left"></i>
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
                        <i class="fa-solid fa-headset"></i>
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
                                <li class="add-to-cart"><a href="#"><i class="fa-solid fa-basket-shopping"></i> 加入購物車</a></li>
                                <li><a href="#" class="popup-ajax"><i class="fa-solid fa-magnifying-glass-plus"></i></a></li>
                                <li><a href="#"><i class="fa-regular fa-heart"></i></a></li>
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

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
.banner_section {
    position: relative;
    height: 600px;
    overflow: hidden;
}

.banner-item {
    height: 600px;
    background-color: #f8f9fa;
}

.banner-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.carousel-caption {
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 100%);
    left: 0;
    right: 0;
    bottom: 0;
    padding: 2rem 1rem;
}

.banner_title_wrap {
    padding: 0.5rem;
}

.banner_title_wrap h5 {
    font-size: 1.5rem;
    font-weight: 500;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

@media (max-width: 768px) {
    .banner_section,
    .banner-item {
        height: 400px;
    }
    
    .banner_title_wrap h5 {
        font-size: 1.2rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 監聽輪播圖切換事件
    document.querySelector('#mainBanner').addEventListener('slide.bs.carousel', function () {
        // 重置動畫
        const animations = this.querySelectorAll('.animate__animated');
        animations.forEach(function(element) {
            element.style.opacity = 0;
            setTimeout(() => {
                element.style.opacity = 1;
            }, 50);
        });
    });
});
</script>
@endpush
@endsection 