@extends('layouts.app')

@section('title', $category->name)

@section('content')
    <!-- START SECTION BREADCRUMB -->
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>{{ $category->name }}</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">首頁</a></li>
                        <li class="breadcrumb-item"><a href="#">商品專區</a></li>
                        @foreach ($categoryPath as $pathItem)
                            @if ($loop->last)
                                <li class="breadcrumb-item active">{{ $pathItem->name }}</li>
                            @else
                                <li class="breadcrumb-item"><a
                                        href="{{ route('categories.show', $pathItem->id) }}">{{ $pathItem->name }}</a></li>
                            @endif
                        @endforeach
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
                <div class="col-lg-9">
                    <div class="row align-items-center mb-4 pb-1">
                        <div class="col-12">
                            <div class="product_header">
                                <div class="product_header_left">
                                    <div class="custom_select">
                                        <select class="form-control form-control-sm">
                                            <option value="order">預設排序</option>
                                            <option value="date">依最新排序</option>
                                            <option value="price">依價格：低到高</option>
                                            <option value="price-desc">依價格：高到低</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="product_header_right">
                                    <div class="products_view">
                                        <a href="javascript:;" class="shorting_icon grid active"><i
                                                class="fa-solid fa-th-large"></i></a>
                                        <a href="javascript:;" class="shorting_icon list"><i
                                                class="fa-solid fa-list"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row shop_container">
                        @forelse($products as $product)
                            <div class="col-md-4 col-6">
                                <div class="product">
                                    <div class="product_img">
                                        <a href="{{ route('products.show', $product->id) }}">
                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a href="#"><i
                                                            class="fa-solid fa-cart-shopping"></i> 加入購物車</a></li>
                                                <li><a href="#" class="popup-ajax"><i
                                                            class="fa-solid fa-arrows-rotate"></i></a></li>
                                                <li><a href="#" class="popup-ajax"><i
                                                            class="fa-solid fa-magnifying-glass"></i></a></li>
                                                <li><a href="#"><i class="fa-solid fa-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a
                                                href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                                        </h6>
                                        <div class="product_price">
                                            <span class="price">${{ number_format($product->price, 2) }}</span>
                                            @if ($product->original_price)
                                                <del>${{ number_format($product->original_price, 2) }}</del>
                                                <div class="on_sale">
                                                    <span>{{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
                                                        Off</span>
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
                                            <p>{{ Str::limit($product->description, 100) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">
                                    此類別目前沒有商品。
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 order-lg-first mt-4 pt-2 mt-lg-0 pt-lg-0">
                    <div class="sidebar">
                        <div class="widget">
                            <h5 class="widget_title">商品分類</h5>
                            <ul class="widget_categories">
                                @foreach ($rootCategories as $rootCategory)
                                    <li class="{{ $categoryPath->contains('id', $rootCategory->id) ? 'active' : '' }}">
                                        <a href="{{ route('categories.show', $rootCategory->id) }}" class="category-link">
                                            {{ $rootCategory->name }}
                                            @if ($subcategories->where('parent_id', $rootCategory->id)->count() > 0)
                                                <i class="fa-solid fa-chevron-down"></i>
                                            @endif
                                        </a>
                                        @if ($subcategories->where('parent_id', $rootCategory->id)->count() > 0)
                                            <ul
                                                class="subcategories {{ $categoryPath->contains('id', $rootCategory->id) ? 'show' : '' }}">
                                                @foreach ($subcategories->where('parent_id', $rootCategory->id) as $subCategory)
                                                    <li
                                                        class="{{ $categoryPath->contains('id', $subCategory->id) ? 'active' : '' }}">
                                                        <a href="{{ route('categories.show', $subCategory->id) }}"
                                                            class="subcategory-link">
                                                            {{ $subCategory->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const categoryLinks = document.querySelectorAll('.category-link');
                                categoryLinks.forEach(link => {
                                    link.addEventListener('click', function(e) {
                                        if (this.querySelector('i')) {
                                            e.preventDefault();
                                            const parent = this.parentElement;
                                            const subMenu = parent.querySelector('.subcategories');
                                            if (subMenu) {
                                                subMenu.classList.toggle('show');
                                                parent.classList.toggle('active');
                                            }
                                        }
                                    });
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->
@endsection


@push('styles')
    <style>
        .widget_categories {
            list-style: none;
            padding: 0;
            margin: 0;
            background: #fff;
            border-radius: 8px;
        }

        .widget_categories li {
            margin: 0;
            border-bottom: 1px solid #eee;
        }

        .widget_categories li:last-child {
            border-bottom: none;
        }

        .widget_categories li a::before {
            content: "";
        }

        .category-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .category-link:hover {
            background-color: #f8f9fa;
            color: #333;
        }

        .category-link i {
            font-size: 12px;
            color: #999;
            transition: transform 0.3s ease;
        }

        .active>.category-link i {
            transform: rotate(180deg);
        }

        .subcategories {
            display: none;
            list-style: none;
            padding: 0;
            background: #f8f9fa;
        }

        .subcategories.show {
            display: block;
        }

        .subcategory-link {
            display: block;
            padding: 8px 16px;
            padding-left: 32px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            position: relative;
        }

        .subcategory-link::before {
            content: "";
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 8px;
            height: 1px;
            background-color: #666;
        }

        .subcategory-link:hover {
            color: #0066cc;
            background-color: #f0f0f0;
        }

        .widget_categories li.active>.category-link {
            color: #0066cc;
        }

        .subcategories li.active .subcategory-link {
            color: #0066cc;
            background-color: #f0f0f0;
        }
    </style>
@endpush
