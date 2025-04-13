@extends('layouts.app')

@section('title', '會員註冊')

@section('content')
<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1>會員註冊</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">首頁</a></li>
                    <li class="breadcrumb-item active">會員註冊</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION BREADCRUMB -->

<!-- START REGISTER SECTION -->
<div class="login_register_wrap section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-10">
                <div class="login_wrap">
                    <div class="padding_eight_all bg-white">
                        <div class="heading_s1">
                            <h3>會員註冊</h3>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="姓名" required autocomplete="name" autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="電子郵件" required autocomplete="email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="密碼" required autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <input class="form-control" type="password" name="password_confirmation" placeholder="確認密碼" required autocomplete="new-password">
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-fill-out btn-block" name="register">註冊</button>
                            </div>
                        </form>
                        <div class="different_login">
                            <span> 或</span>
                        </div>
                        <ul class="btn-login list_none text-center">
                            <li><a href="#" class="btn btn-facebook"><i class="fa-brands fa-facebook-f"></i>Facebook</a></li>
                            <li><a href="#" class="btn btn-google"><i class="fa-brands fa-google"></i>Google</a></li>
                        </ul>
                        <div class="form-note text-center">已經有帳號？ <a href="{{ route('login') }}">立即登入</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END REGISTER SECTION -->
@endsection 