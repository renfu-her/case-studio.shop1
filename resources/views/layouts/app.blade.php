<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Shopwise 是一個功能強大的電子商務網站模板，適用於任何電子商務網站。該模板專為銷售時尚產品、鞋子、包包、化妝品、服裝、太陽眼鏡、家具、兒童產品、電子產品、文具產品和體育用品而設計。">
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
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/simple-line-icons.css') }}">

    <!--- owl carousel CSS-->
    <link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.theme.default.min.css') }}">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <!-- Slick CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}">

    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css?t=' . time()) }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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
        <div class="bottom_header dark_skin main_menu_uppercase">
            <div class="container">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img class="logo_light" src="{{ asset('assets/images/logo_light.png') }}" alt="logo">
                        <img class="logo_dark" src="{{ asset('assets/images/logo_dark.png') }}" alt="logo">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-expanded="false">
                        <span class="fa-solid fa-bars"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li><a class="nav-link" href="{{ route('home') }}">首頁</a></li>
                            <li><a class="nav-link" href="#">活動訊息</a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">商品專區</a>
                                <div class="dropdown-menu">
                                    <ul>
                                        @foreach($categories->where('parent_id', 0) as $category)
                                        <li><a class="dropdown-item nav-link nav_item" href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">會員專區</a>
                                <div class="dropdown-menu">
                                    <ul>
                                        @if(!Auth::guard('member')->check())
                                            <li><a class="dropdown-item nav-link nav_item" href="{{ route('login') }}">登入</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="{{ route('register') }}">加入會員</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="{{ route('password.request') }}">忘記密碼</a></li>
                                        @else
                                            <li><a class="dropdown-item nav-link nav_item" href="{{ route('member.index') }}">會員中心</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="{{ route('member.orders') }}">訂單查詢</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="{{ route('member.edit') }}">會員資料</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="{{ route('member.change-password') }}">修改密碼</a></li>
                                            <li>
                                                <form action="{{ route('logout') }}" method="POST" class="d-none" id="logout-form">
                                                    @csrf
                                                </form>
                                                <a class="dropdown-item nav-link nav_item" href="#" 
                                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    登出
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                            <li><a class="nav-link" href="#">常見問答</a></li>
                        </ul>
                    </div>
                    <ul class="navbar-nav attr-nav align-items-center">
                        <li><a href="#" class="nav-link"><i class="fa-solid fa-magnifying-glass"></i></a></li>
                        <li class="dropdown cart_dropdown">
                            <a class="nav-link cart_icon" href="#" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-cart-shopping"></i><span class="cart_count">2</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <ul class="cart_list">
                                    <li>
                                        <a href="#" class="item_remove"><i class="fa-solid fa-xmark"></i></a>
                                        <a href="#"><img src="{{ asset('assets/images/cart_thamb1.jpg') }}"
                                                alt="cart_thumb">變體產品 1</a>
                                        <span class="cart_quantity"> 1 x <span class="cart_amount"> <span
                                                    class="price_symbole">$</span></span>78.00</span>
                                    </li>
                                    <li>
                                        <a href="#" class="item_remove"><i class="fa-solid fa-xmark"></i></a>
                                        <a href="#"><img src="{{ asset('assets/images/cart_thamb2.jpg') }}"
                                                alt="cart_thumb">變體產品 2</a>
                                        <span class="cart_quantity"> 1 x <span class="cart_amount"> <span
                                                    class="price_symbole">$</span></span>81.00</span>
                                    </li>
                                </ul>
                                <div class="cart_footer">
                                    <p class="cart_total"><strong>小計:</strong> <span class="cart_price"> <span
                                                class="price_symbole">$</span></span>159.00</p>
                                    <p class="cart_buttons"><a href="#"
                                            class="btn btn-fill-line rounded-0 view-cart">查看購物車</a><a href="#"
                                            class="btn btn-fill-outline rounded-0 checkout">結帳</a></p>
                                </div>
                            </div>
                        </li>
                        <li><a class="nav-link" href="#"><i class="fa-solid fa-user"></i></a></li>
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
                        <div class="widget">
                            <div class="footer_logo">
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('assets/images/logo_light.png') }}" alt="logo">
                                </a>
                            </div>
                            <p>我們提供最好的產品和服務，讓您的購物體驗更加愉快。</p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6">
                        <div class="widget">
                            <h6 class="widget_title">快速連結</h6>
                            <ul class="widget_links">
                                <li><a href="{{ route('home') }}">首頁</a></li>
                                <li><a href="#">活動訊息</a></li>
                                <li><a href="#">商品專區</a></li>
                                <li><a href="{{ route('member.index') }}">會員專區</a></li>
                                <li><a href="#">常見問答</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6">
                        <div class="widget">
                            <h6 class="widget_title">顧客權益</h6>
                            <ul class="widget_links">
                                <li><a href="#">服務條款</a></li>
                                <li><a href="#">隱私權政策</a></li>
                                <li><a href="#">退換貨說明</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12">
                        <div class="widget">
                            <h6 class="widget_title">聯絡我們</h6>
                            <ul class="contact_info contact_info_light">
                                <li>
                                    <i class="fa-solid fa-location-dot"></i>
                                    <p>台北市信義區信義路五段7號</p>
                                </li>
                                <li>
                                    <i class="fa-solid fa-envelope"></i>
                                    <a href="mailto:info@example.com">info@example.com</a>
                                </li>
                                <li>
                                    <i class="fa-solid fa-phone"></i>
                                    <p>02-1234-5678</p>
                                </li>
                                <li>
                                    <i class="fa-regular fa-clock"></i>
                                    <p>週一至週五 09:00 - 18:00</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom_footer border-top-tran">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <p class="mb-0 text-center">© {{ date('Y') }} {{ config('app.name') }}. 版權所有.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- END FOOTER -->

    <!-- jQuery JS -->
    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
    <!-- popper min js -->
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <!-- Latest compiled and minified Bootstrap -->
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- owl-carousel min js  -->
    <script src="{{ asset('assets/owlcarousel/js/owl.carousel.min.js') }}"></script>
    <!-- magnific-popup min js  -->
    <script src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>
    <!-- waypoints min js  -->
    <script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
    <!-- parallax js  -->
    <script src="{{ asset('assets/js/parallax.js') }}"></script>
    <!-- countdown js  -->
    <script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
    <!-- imagesloaded js -->
    <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <!-- isotope min js -->
    <script src="{{ asset('assets/js/isotope.min.js') }}"></script>
    <!-- jquery.dd.min js -->
    <script src="{{ asset('assets/js/jquery.dd.min.js') }}"></script>
    <!-- slick js -->
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <!-- elevatezoom js -->
    <script src="{{ asset('assets/js/jquery.elevatezoom.js') }}"></script>
    <!-- scripts js -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

    @stack('scripts')
</body>

</html>
