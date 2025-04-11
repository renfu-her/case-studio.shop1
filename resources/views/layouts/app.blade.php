<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Shopwise 是一個功能強大的電子商務網站模板，適用於任何電子商務網站。該模板專為銷售時尚產品、鞋子、包包、化妝品、服裝、太陽眼鏡、家具、兒童產品、電子產品、文具產品和體育用品而設計。">
    <meta name="keywords" content="電子商務, 電子商店, 時尚商店, 家具商店, bootstrap 4, 簡潔, 極簡, 現代, 線上商店, 響應式, 零售, 購物, 電子商務商店">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SITE TITLE -->
    <title>@yield('title', config('app.name'))</title>
    
    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">
    
    <!-- Animation CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    
    <!-- Latest Bootstrap min CSS -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
    
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/simple-line-icons.css') }}">
    
    <!-- Slick CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}">
    
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    
    @stack('styles')
</head>
<body>
    <!-- LOADER -->
    <div id="preloader">
        <div class="loader_wrap">
            <div class="loader"></div>
        </div>
    </div>
    <!-- END LOADER -->
    
    <!-- HEADER -->
    <header class="header_wrap dark_skin fixed-top">
        <div class="top_header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <ul class="contact_info text-center text-md-start">
                            <li><i class="ion-ios-telephone-outline"></i>+01 123 456 7890</li>
                            <li><i class="ion-ios-email-outline"></i>info@example.com</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list_header_social text-center text-md-end">
                            <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                            <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                            <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                            <li><a href="#"><i class="ion-social-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom_header dark_skin main_menu_uppercase">
            <div class="container">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img class="logo_light" src="{{ asset('assets/images/logo_light.png') }}" alt="logo">
                        <img class="logo_dark" src="{{ asset('assets/images/logo_dark.png') }}" alt="logo">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-expanded="false">
                        <span class="ion-android-menu"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="dropdown">
                                <a data-bs-toggle="dropdown" class="nav-link dropdown-toggle {{ request()->routeIs('home') ? 'active' : '' }}" href="#">首頁</a>
                                <div class="dropdown-menu">
                                    <ul>
                                        <li><a class="dropdown-item nav-link nav_item {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">時尚 1</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="#">時尚 2</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="#">家具 1</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="#">家具 2</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="#">電子產品 1</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="#">電子產品 2</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">頁面</a>
                                <div class="dropdown-menu">
                                    <ul>
                                        <li><a class="dropdown-item nav-link nav_item" href="#">關於我們</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="#">聯絡我們</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="#">常見問題</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="#">404 錯誤頁面</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="#">登入</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="#">註冊</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="#">條款和條件</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="dropdown dropdown-mega-menu">
                                <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">產品</a>
                                <div class="dropdown-menu">
                                    <ul class="mega-menu d-lg-flex">
                                        <li class="mega-menu-col col-lg-3">
                                            <ul>
                                                <li class="dropdown-header">女裝</li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">上衣</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">褲子</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">裙子</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">鞋子</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">配飾</a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-menu-col col-lg-3">
                                            <ul>
                                                <li class="dropdown-header">男裝</li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">上衣</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">褲子</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">鞋子</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">配飾</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">手錶</a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-menu-col col-lg-3">
                                            <ul>
                                                <li class="dropdown-header">兒童</li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">上衣</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">褲子</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">鞋子</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">玩具</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">配飾</a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-menu-col col-lg-3">
                                            <ul>
                                                <li class="dropdown-header">配飾</li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">包包</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">手錶</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">眼鏡</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">珠寶</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">帽子</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <div class="d-lg-flex menu_banners row g-3 px-3">
                                        <div class="col-sm-4">
                                            <div class="header-banner">
                                                <img src="{{ asset('assets/images/menu_banner1.jpg') }}" alt="menu_banner1">
                                                <div class="banne_info">
                                                    <h6>10% 折扣</h6>
                                                    <h4>新品上市</h4>
                                                    <a href="#">立即購買</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="header-banner">
                                                <img src="{{ asset('assets/images/menu_banner2.jpg') }}" alt="menu_banner2">
                                                <div class="banne_info">
                                                    <h6>15% 折扣</h6>
                                                    <h4>特價商品</h4>
                                                    <a href="#">立即購買</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="header-banner">
                                                <img src="{{ asset('assets/images/menu_banner3.jpg') }}" alt="menu_banner3">
                                                <div class="banne_info">
                                                    <h6>20% 折扣</h6>
                                                    <h4>限時特惠</h4>
                                                    <a href="#">立即購買</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li><a class="nav-link nav_item" href="#">關於我們</a></li>
                            <li><a class="nav-link nav_item" href="#">聯絡我們</a></li>
                        </ul>
                    </div>
                    <ul class="navbar-nav attr-nav align-items-center">
                        <li><a href="#" class="nav-link"><i class="linearicons-magnifier"></i></a></li>
                        <li class="dropdown cart_dropdown">
                            <a class="nav-link cart_icon" href="#" data-bs-toggle="dropdown"><i class="linearicons-cart"></i><span class="cart_count">2</span></a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <ul class="cart_list">
                                    <li>
                                        <a href="#" class="item_remove"><i class="ion-close"></i></a>
                                        <a href="#"><img src="{{ asset('assets/images/cart_thamb1.jpg') }}" alt="cart_thumb">變體產品 1</a>
                                        <span class="cart_quantity"> 1 x <span class="cart_amount"> <span class="price_symbole">$</span></span>78.00</span>
                                    </li>
                                    <li>
                                        <a href="#" class="item_remove"><i class="ion-close"></i></a>
                                        <a href="#"><img src="{{ asset('assets/images/cart_thamb2.jpg') }}" alt="cart_thumb">變體產品 2</a>
                                        <span class="cart_quantity"> 1 x <span class="cart_amount"> <span class="price_symbole">$</span></span>81.00</span>
                                    </li>
                                </ul>
                                <div class="cart_footer">
                                    <p class="cart_total"><strong>小計:</strong> <span class="cart_price"> <span class="price_symbole">$</span></span>159.00</p>
                                    <p class="cart_buttons"><a href="#" class="btn btn-fill-line rounded-0 view-cart">查看購物車</a><a href="#" class="btn btn-fill-outline rounded-0 checkout">結帳</a></p>
                                </div>
                            </div>
                        </li>
                        <li><a class="nav-link" href="#"><i class="linearicons-user"></i></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <!-- END HEADER -->
    
    <!-- MAIN CONTENT -->
    <main>
        @yield('content')
    </main>
    <!-- END MAIN CONTENT -->
    
    <!-- FOOTER -->
    <footer class="footer_dark">
        <div class="footer_top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="widget widget_about">
                            <div class="logo_footer">
                                <img src="{{ asset('assets/images/logo_light.png') }}" alt="logo">
                            </div>
                            <p>我們提供最好的產品和服務，讓您的購物體驗更加愉快。</p>
                            <ul class="social_icons social_white social_style1 rounded_social">
                                <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                                <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="widget widget_links">
                            <h4 class="widget-title">快速連結</h4>
                            <ul>
                                <li><a href="#">關於我們</a></li>
                                <li><a href="#">聯絡我們</a></li>
                                <li><a href="#">常見問題</a></li>
                                <li><a href="#">條款和條件</a></li>
                                <li><a href="#">隱私權政策</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="widget widget_links">
                            <h4 class="widget-title">購物</h4>
                            <ul>
                                <li><a href="#">購物車</a></li>
                                <li><a href="#">結帳</a></li>
                                <li><a href="#">我的帳戶</a></li>
                                <li><a href="#">願望清單</a></li>
                                <li><a href="#">訂單追蹤</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="widget widget_links">
                            <h4 class="widget-title">客戶服務</h4>
                            <ul>
                                <li><a href="#">退換貨政策</a></li>
                                <li><a href="#">運送政策</a></li>
                                <li><a href="#">付款方式</a></li>
                                <li><a href="#">常見問題</a></li>
                                <li><a href="#">聯絡我們</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="widget widget_address_cover">
                            <h4 class="widget-title">聯絡我們</h4>
                            <div class="widget_address">
                                <ul>
                                    <li><i class="ion-ios-location-outline"></i> 台北市信義區信義路五段7號</li>
                                    <li><i class="ion-ios-email-outline"></i> info@example.com</li>
                                    <li><i class="ion-ios-telephone-outline"></i> +886 2 1234 5678</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom_footer border-top-tran">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="mb-md-0 text-center text-md-start">© {{ date('Y') }} {{ config('app.name') }}. 版權所有.</p>
                    </div>
                    <div class="col-md-6">
                        <ul class="list_none footer_link text-center text-md-end">
                            <li><a href="#">隱私權政策</a></li>
                            <li><a href="#">條款和條件</a></li>
                            <li><a href="#">退換貨說明</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- END FOOTER -->
    
    <!-- jQuery JS -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <!-- Popper JS -->
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- Plugins JS -->
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    
    @stack('scripts')
</body>
</html> 