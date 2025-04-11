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
            <div class="col-lg-4 col-md-6">
                <div class="categories_box">
                    <a href="#">
                        <img src="{{ asset('assets/images/cat_img1.jpg') }}" alt="cat_img1">
                        <span>女裝</span>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="categories_box">
                    <a href="#">
                        <img src="{{ asset('assets/images/cat_img2.jpg') }}" alt="cat_img2">
                        <span>男裝</span>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="categories_box">
                    <a href="#">
                        <img src="{{ asset('assets/images/cat_img3.jpg') }}" alt="cat_img3">
                        <span>兒童</span>
                    </a>
                </div>
            </div>
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
            <div class="col-lg-3 col-md-4 col-6">
                <div class="product_box">
                    <div class="product_img">
                        <a href="#">
                            <img src="{{ asset('assets/images/product_img1.jpg') }}" alt="product_img1">
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
                        <h6 class="product_title"><a href="#">時尚連身裙</a></h6>
                        <div class="product_price">
                            <span class="price">$45.00</span>
                            <del>$55.25</del>
                            <div class="on_sale">
                                <span>25% 折扣</span>
                            </div>
                        </div>
                        <div class="rating">
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star-half"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6">
                <div class="product_box">
                    <div class="product_img">
                        <a href="#">
                            <img src="{{ asset('assets/images/product_img2.jpg') }}" alt="product_img2">
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
                        <h6 class="product_title"><a href="#">休閒外套</a></h6>
                        <div class="product_price">
                            <span class="price">$55.00</span>
                            <del>$65.25</del>
                            <div class="on_sale">
                                <span>25% 折扣</span>
                            </div>
                        </div>
                        <div class="rating">
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6">
                <div class="product_box">
                    <div class="product_img">
                        <a href="#">
                            <img src="{{ asset('assets/images/product_img3.jpg') }}" alt="product_img3">
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
                        <h6 class="product_title"><a href="#">牛仔褲</a></h6>
                        <div class="product_price">
                            <span class="price">$65.00</span>
                            <del>$75.25</del>
                            <div class="on_sale">
                                <span>25% 折扣</span>
                            </div>
                        </div>
                        <div class="rating">
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star-half"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6">
                <div class="product_box">
                    <div class="product_img">
                        <a href="#">
                            <img src="{{ asset('assets/images/product_img4.jpg') }}" alt="product_img4">
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
                        <h6 class="product_title"><a href="#">運動鞋</a></h6>
                        <div class="product_price">
                            <span class="price">$75.00</span>
                            <del>$85.25</del>
                            <div class="on_sale">
                                <span>25% 折扣</span>
                            </div>
                        </div>
                        <div class="rating">
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END SECTION PRODUCTS -->

<!-- START SECTION BANNER -->
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="banner_img">
                    <a href="#"><img src="{{ asset('assets/images/banner_img2.jpg') }}" alt="banner_img2"></a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="banner_img">
                    <a href="#"><img src="{{ asset('assets/images/banner_img3.jpg') }}" alt="banner_img3"></a>
                </div>
            </div>
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
                            <form action="#" method="post">
                                <div class="newsletter_form">
                                    <input type="text" class="form-control" placeholder="輸入您的電子郵件">
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