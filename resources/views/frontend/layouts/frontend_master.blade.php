@php
    $default_setting = App\Models\Default_setting::first();
    $seo_setting = App\Models\Seo_setting::first();
    App\Models\Visitor::insert(['ip_address' =>  $_SERVER['REMOTE_ADDR'], 'visit_time' =>  Carbon\Carbon::now() ])
@endphp
@auth
    @php
        App\Models\User::where('id', Auth::user()->id)->update(['last_active' =>  Carbon\Carbon::now() ])
    @endphp
@endauth

<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Meta Tag -->
    <meta name="description" content="{{ $seo_setting->description }}">
    <meta name="keywords" content="{{ $seo_setting->keywords }}">
    <meta name="author" content="{{ $default_setting->app_name }}">
    <!-- Twitter Meta Tag -->
    <meta name="twitter:card" content="{{ asset('uploads/default_photo') }}/{{ $seo_setting->seo_image }}" />
    <meta name="twitter:site" content="{{ $default_setting->twitter_link }}" />
    <meta name="twitter:title" content="{{ $seo_setting->title }}" />
    <meta name="twitter:description" content="{{ $seo_setting->description }}" />
    <meta name="twitter:image" content="{{ asset('uploads/default_photo') }}/{{ $seo_setting->seo_image }}" />
    <meta name="twitter:image:alt" content="{{ $default_setting->app_name }}">
    <!-- Facebook Meta Tag -->
    <meta property="og:type" content="eCommerce" />
    <meta property="og:title" content="{{ $seo_setting->title }}" />
    <meta property="og:description" content="{{ $seo_setting->description }}" />
    <meta property="og:url" content="{{ $seo_setting->url }}" />
    <meta property="og:image" content="{{ asset('uploads/default_photo') }}/{{ $seo_setting->seo_image }}" />
    <meta property="og:image:alt" content="{{ $default_setting->app_name }}" />
    <meta property="og:site_name" content="{{ $default_setting->facebook_link }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title>{{ env('APP_NAME') }} | @yield('title_bar')</title>
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('uploads/default_photo')}}/{{$default_setting->favicon}}">
    <!-- CSS here -->
    <link rel="stylesheet" href="{{asset('frontend')}}/css/preloader.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/bootstrap.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/meanmenu.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/animate.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/owl-carousel.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/select2.min.css"/>
    <link rel="stylesheet" href="{{asset('frontend')}}/css/swiper-bundle.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/backtotop.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/magnific-popup.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/nice-select.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/flaticon/flaticon.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/font-awesome-pro.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/default.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/style.css">
</head>

<body>
    <!-- preloader start -->
    <div id="loading">
        <div id="loading-center">
            <div id="loading-center-absolute">
                <svg viewBox="0 0 58 58" id="mustard" class="product">
                    <g>
                        <path style="fill:#ED7161;" d="M39.869,58H18.131C16.954,58,16,57.046,16,55.869V12.621C16,11.726,16.726,11,17.621,11h22.757
                    C41.274,11,42,11.726,42,12.621v43.248C42,57.046,41.046,58,39.869,58z" />
                        <polygon style="fill:#D13834;" points="35,11 23,11 27.615,0 30.385,0 	" />
                        <rect x="16" y="16" style="fill:#D75A4A;" width="26" height="2" />
                        <rect x="20" y="11" style="fill:#D75A4A;" width="2" height="6" />
                        <rect x="25" y="11" style="fill:#D75A4A;" width="2" height="6" />
                        <rect x="30" y="11" style="fill:#D75A4A;" width="2" height="6" />
                        <rect x="36" y="11" style="fill:#D75A4A;" width="2" height="6" />
                        <circle style="fill:#D13834;" cx="29" cy="36" r="10" />
                    </g>
                </svg>
                <svg viewBox="0 0 49.818 49.818" id="meat" class="product">
                    <g>
                        <path style="fill:#994530;"
                            d="M0.953,38.891c0,0,3.184,6.921,11.405,9.64c1.827,0.604,3.751,0.751,5.667,0.922
                        c7.866,0.703,26.714-0.971,31.066-18.976c1.367-5.656,0.76-11.612-1.429-17.003C44.51,5.711,37.447-4.233,22.831,2.427
                        c-8.328,3.795-7.696,10.279-5.913,14.787c2.157,5.456-2.243,11.081-8.06,10.316C1.669,26.584-1.825,30.904,0.953,38.891z" />
                        <g>
                            <path style="fill:#D75A4A;" d="M4.69,37.18c0.402,0.785,3.058,5.552,9.111,7.554c1.335,0.441,2.863,0.577,4.482,0.72l0.282,0.025
                            c0.818,0.073,1.698,0.11,2.617,0.11c18.18,0,22.854-11.218,24.02-16.041c1.134-4.693,0.706-9.703-1.235-14.488
                            C41.049,7.874,36.856,4.229,31.506,4.229c-2.21,0-4.683,0.615-7.349,1.83c-2.992,1.364-6.676,3.921-4.13,10.36
                            c1.284,3.25,0.912,6.746-1.023,9.591c-2.17,3.191-6.002,4.901-9.895,4.39c-0.493-0.065-0.966-0.099-1.404-0.099
                            c-1.077,0-2.502,0.198-3.173,1.143C3.765,32.524,3.823,34.609,4.69,37.18z" />
                            <path style="fill:#C64940;" d="M21.184,46.589c-0.948,0-1.858-0.038-2.706-0.114l-0.283-0.025
                            c-1.674-0.147-3.257-0.287-4.706-0.767c-6.376-2.108-9.188-7.073-9.688-8.047l-0.058-0.137c-0.984-2.917-0.993-5.273-0.026-6.635
                            c0.912-1.285,2.89-1.807,5.524-1.456c3.537,0.466,6.959-1.054,8.936-3.961c1.746-2.565,2.082-5.723,0.921-8.661
                            c-3.189-8.065,2.707-10.754,4.645-11.638c9.68-4.407,16.81-1.155,21.152,9.535c2.021,4.981,2.464,10.202,1.28,15.099
                            C44.953,34.836,40.073,46.589,21.184,46.589z M5.613,36.787c0.401,0.758,2.936,5.155,8.503,6.997
                            c1.229,0.406,2.699,0.536,4.256,0.673l0.284,0.025c0.788,0.07,1.639,0.106,2.527,0.106c17.469,0,21.938-10.683,23.048-15.276
                            c1.084-4.487,0.672-9.286-1.19-13.877C40.29,8.663,36.409,5.229,31.506,5.229c-2.067,0-4.4,0.585-6.934,1.74
                            c-3.02,1.376-5.81,3.532-3.615,9.083c1.408,3.563,0.998,7.398-1.126,10.521c-2.404,3.534-6.563,5.386-10.852,4.818
                            c-1.793-0.236-3.197,0.019-3.632,0.632C4.912,32.636,4.756,34.207,5.613,36.787z" />
                        </g>
                        <g>
                            <circle style="fill:#E6E6E6;" cx="32.455" cy="12.779" r="4" />
                            <path style="fill:#7A3726;" d="M32.455,17.779c-2.757,0-5-2.243-5-5s2.243-5,5-5s5,2.243,5,5S35.212,17.779,32.455,17.779z
                            M32.455,9.779c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S34.109,9.779,32.455,9.779z" />
                        </g>
                        <path style="fill:#C64940;" d="M25.617,45.684l-1.941-0.479c0.435-1.761-1.063-3.216-3.446-4.859
                        c-2.875-1.984-4.817-5.117-5.327-8.595c-0.186-1.266-0.425-2.285-0.428-2.295l1.922-0.548c0.01,0.028,1.09,3.104,3.978,4.314
                        c2.094,0.877,4.667,0.598,7.648-0.832c11.578-5.554,17.102-2.646,17.332-2.52l-0.967,1.752c-0.04-0.021-4.97-2.48-15.5,2.57
                        c-3.53,1.694-6.662,1.984-9.312,0.863c-0.801-0.339-1.49-0.779-2.078-1.265c0.769,1.974,2.11,3.695,3.867,4.907
                        C23.149,39.931,26.472,42.222,25.617,45.684z" />
                        <path style="fill:#C64940;" d="M27.074,27.586c-5.37,0-7.605-3.694-7.633-3.74l1.727-1.01l-0.863,0.505l0.859-0.511
                        c0.108,0.179,2.714,4.335,9.738,2.105c1.54-0.794,12.038-6.002,15.619-2.289l-1.439,1.389c-1.979-2.052-9.229,0.576-13.332,2.714
                        l-0.154,0.064C29.892,27.364,28.389,27.586,27.074,27.586z" />
                    </g>
                </svg>
                <svg viewBox="0 0 49 49" id="soda" class="product">
                    <g>
                        <path style="fill:#E22F37;" d="M9.5,27V5.918c0-1.362,0.829-2.587,2.094-3.093l0,0C12.642,2.406,13.5,1.14,13.5,0.011L13.5,0v0
                        l11,0l11,0v0v0.011c0,1.129,0.858,2.395,1.906,2.814l0,0c1.265,0.506,2.094,1.73,2.094,3.093V27v-5v21.082
                        c0,1.362-0.829,2.587-2.094,3.093h0c-1.048,0.419-1.906,1.686-1.906,2.814V49l0,0h-11h-11l0,0l0-0.011
                        c0-1.129-0.858-2.395-1.906-2.814h0c-1.265-0.506-2.094-1.73-2.094-3.093V22" />
                        <path style="fill:#F75B57;"
                            d="M18.5,7h-5c-0.553,0-1-0.447-1-1s0.447-1,1-1h5c0.553,0,1,0.447,1,1S19.053,7,18.5,7z" />
                        <path style="fill:#F75B57;"
                            d="M35.5,7h-13c-0.553,0-1-0.447-1-1s0.447-1,1-1h13c0.553,0,1,0.447,1,1S36.053,7,35.5,7z" />
                        <path style="fill:#994530;"
                            d="M18.5,45h-5c-0.553,0-1-0.447-1-1s0.447-1,1-1h5c0.553,0,1,0.447,1,1S19.053,45,18.5,45z" />
                        <path style="fill:#994530;"
                            d="M35.5,45h-13c-0.553,0-1-0.447-1-1s0.447-1,1-1h13c0.553,0,1,0.447,1,1S36.053,45,35.5,45z" />
                        <polygon style="fill:#E6E6E6;" points="39.5,32 9.5,42 9.5,20 39.5,10 	" />
                        <polygon style="fill:#F9D70B;" points="39.5,28 9.5,38 9.5,24 39.5,14 	" />
                    </g>
                </svg>
                <div class="cart-container">
                    <svg viewBox="0 0 512 512" id="cart">
                        <circle cx="376.8" cy="440" r="55" />
                        <circle cx="192" cy="440" r="55" />
                        <polygon points="128,0 0.8,0 0.8,32 104.8,32 136.8,124.8 170.4,124.8 " />
                        <polygon style="fill:#ED7161;" points="250.4,49.6 224,124.8 411.2,124.8 " />
                        <polygon style="fill:#ee5a46;" points="411.2,124.8 224,124.8 170.4,124.8 136.8,124.8 68,124.8 141.6,361.6 427.2,361.6
                    511.2,124.8 " />
                        <g>
                            <rect x="166.4" y="185.6" style="fill:#FFFFFF;" width="255.2" height="16" />
                            <rect x="166.4" y="237.6" style="fill:#FFFFFF;" width="166.4" height="16" />
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <!-- preloader end -->

    <!-- back to top start -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- back to top end -->

    <!-- header-start -->
    <header class="header d-blue-bg" >
        <div class="header-top">
            <div class="container">
                <div class="header-inner">
                    <div class="row align-items-center">
                        <div class="col-xl-6 col-lg-7">
                            <div class="header-inner-start">
                                <div class="support d-none d-sm-block">
                                    <p>Need Help? <a href="tel:{{$default_setting->support_phone}}">{{$default_setting->support_phone}}</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-5 d-none d-lg-block">
                            <div class="header-inner-end text-md-end">
                                <div class="ovic-menu-wrapper">
                                    <ul>
                                        <li><a href="{{route('order.tracking')}}">Order Tracking</a></li>
                                        <li><a href="{{route('faqs')}}">FAQs</a></li>
                                        <li><a href="{{route('about')}}">About Us</a></li>
                                        <li><a href="{{route('contact')}}">Contact Us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-mid" >
            <div class="container">
                <div class="heade-mid-inner">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4">
                            <div class="header__info">
                                <div class="logo">
                                    <a href="{{ route('index') }}" class="logo-image"><img src="{{asset('uploads/default_photo')}}/{{$default_setting->logo_photo}}" alt="logo"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-4 d-none d-lg-block">
                            <div class="header__search">
                                <form action="{{ route('search.products') }}" method="GET">
                                    <div class="header__search-box">
                                        <input class="search-input" name="product_name" id="findProduct" onfocus="showSearchResult()" onblur="hideSearchResult()" type="text" placeholder="I'm shopping for..."  value="{{request('product_name')}}">
                                        <button class="button" type="submit"><i class="far fa-search"></i></button>
                                    </div>
                                    <div class="header__search-cat">
                                        @php
                                        $categories = App\Models\Category::where('status', 'Yes')->get();
                                        @endphp
                                        <select name="category_id">
                                            <option value="ALL" {{ request('category_id') == "All" ? 'selected' : '' }}>All Categories</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{$category->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                                <div class="search_result">
                                    <ul id="suggest_products">

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-8 col-sm-8">
                            <div class="header-action">
                                <div class="block-userlink">
                                    @guest
                                    <a class="icon-link" href="{{ route('login') }}">
                                        <i class="flaticon-user"></i>
                                        <span class="text">
                                            <span class="sub">Register </span>
                                            Login
                                        </span>
                                    </a>
                                    @else
                                    <a class="icon-link" href="{{ route('dashboard') }}">
                                        <i class="flaticon-user"></i>
                                        <span class="text">
                                            <span class="sub">Dashboard </span>
                                            {{ Auth::user()->name }}
                                        </span>
                                    </a>
                                    @endguest
                                </div>
                                <div class="block-wishlist action">
                                    <a class="icon-link" href="{{ route('wishlist') }}">
                                        <i class="flaticon-heart"></i>
                                        <span class="count" id="header_wishlist_num">
                                            @auth
                                                {{ App\Models\Wishlist::where('user_id', Auth::user()->id)->count() }}
                                            @else
                                            0
                                            @endauth
                                        </span>
                                        <span class="text">
                                            <span class="sub">Favorite</span>
                                            My Wishlist
                                        </span>
                                    </a>
                                </div>
                                <div class="block-cart action">
                                    <a class="icon-link" href="{{ route('cart') }}">
                                        <i class="flaticon-shopping-bag"></i>
                                        <span class="count" id="header_cart_count">
                                            0
                                        </span>
                                        <span class="text">
                                            <span class="sub">Your Cart:</span>
                                            ৳ <strong class="header_cart_sub_total">00</strong>
                                        </span>
                                    </a>
                                    <div class="cart">
                                        <div class="cart__mini">
                                            <ul>
                                                <li>
                                                    <div class="cart__title">
                                                        <h4>Your Cart</h4>
                                                    </div>
                                                </li>
                                                <li id="header_cart_data">

                                                </li>
                                                <li>
                                                    <div
                                                        class="cart__sub d-flex justify-content-between align-items-center">
                                                        <h6>Subtotal</h6>
                                                        <span>৳
                                                            <span class="cart__sub-total header_cart_sub_total">
                                                            00
                                                            </span>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <a href="{{ route('cart') }}" class="wc-cart mb-10">View cart</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header__bottom" id="navbar">
            <div class="container">
                <div class="row g-0 align-items-center">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4">
                        <div class="cat__menu-wrapper side-border d-none d-lg-block">
                            <div class="cat-toggle">
                                <button type="button" class="cat-toggle-btn cat-toggle-btn-1"><i
                                        class="fal fa-bars"></i>Category List</button>
                                <div class="cat__menu">
                                    <nav id="mobile-menu" style="display: block;">
                                        <ul>
                                            @forelse ($categories as $category)
                                            @php
                                                $subcategories = App\Models\Subcategory::where('status', 'Yes')->where('category_id', $category->id)->get();
                                            @endphp
                                            <li>
                                                <a href="{{ route('category.wise.product', $category->category_slug) }}">{{$category->category_name}}<i class="far fa-angle-down"></i></a>
                                                <ul class="submenu">
                                                    @forelse ($subcategories as $subcategory)
                                                    @php
                                                        $childcategories = App\Models\Childcategory::where('status', 'Yes')->where('subcategory_id', $subcategory->id)->get();
                                                    @endphp
                                                    <li>
                                                        <a href="{{ route('subcategory.wise.product', $subcategory->subcategory_slug) }}">{{$subcategory->subcategory_name}}</a>
                                                        <ul class="submenu">
                                                            @forelse ($childcategories as $childcategory)
                                                            <li><a href="{{ route('childcategory.wise.product', $childcategory->childcategory_slug) }}">{{$childcategory->childcategory_name}}</a></li>
                                                            @empty
                                                            <li class="text-danger">Childcategory Not Found</li>
                                                            @endforelse
                                                        </ul>
                                                    </li>
                                                    @empty
                                                    <li class="text-danger">Subcategory Not Found</li>
                                                    @endforelse
                                                </ul>
                                            </li>
                                            @empty
                                            <div class="alert alert-danger" >
                                                <strong>Category Not Found</strong>
                                            </div>
                                            @endforelse
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-9 col-md-8 col-sm-8">
                        <div class="header__bottom-left d-flex d-xl-block align-items-center">
                            <div class="side-menu d-lg-none mr-20">
                                <button type="button" class="side-menu-btn offcanvas-toggle-btn"><i class="fas fa-bars"></i></button>
                            </div>
                            <div class="main-menu d-none d-lg-block">
                                <nav>
                                    <ul>
                                        <li><a href="{{route('all.product')}}">All Product</a></li>
                                        <li><a href="{{route('all.category')}}">All Category</a></li>
                                        <li><a href="{{route('all.brand')}}">All Brand</a></li>
                                        <li><a href="{{route('all.blog')}}">All Blog</a></li>
                                        <li><a href="{{route('all.flashsale')}}">All Flashsale</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4">
                        <div class="d-flex justify-content-evenly d-none" id="auth">
                            <div class="block-userlink text-white" >
                                @guest
                                <a class="icon-link" href="{{ route('login') }}">
                                    <i class="flaticon-user"></i>
                                    <span class="text">
                                        <span class="sub">Login</span>
                                    </span>
                                </a>
                                @else
                                <a class="icon-link" href="{{route('dashboard')}}">
                                    <i class="flaticon-user"></i>
                                    <span class="text">
                                        {{ Auth::user()->name }}
                                    </span>
                                </a>
                                @endguest
                            </div>
                            <div class="block-cart action text-white">
                                <a class="icon-link" href="{{route('cart')}}">
                                    <i class="flaticon-shopping-bag"></i>
                                    <span class="text">
                                        ৳ <strong class="header_cart_sub_total">00</strong>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-end -->

    <!-- offcanvas area start -->
    <div class="offcanvas__area">
        <div class="offcanvas__wrapper">
            <div class="offcanvas__close">
                <button class="offcanvas__close-btn" id="offcanvas__close-btn">
                    <i class="fal fa-times"></i>
                </button>
            </div>
            <div class="offcanvas__content">
                <div class="offcanvas__logo mb-40">
                    <a href="{{route('index')}}">
                        <img src="{{asset('uploads/default_photo')}}/{{$default_setting->logo_photo}}" alt="logo">
                    </a>
                </div>
                <div class="offcanvas__search mb-25">
                    <form action="{{route('search.products')}}" method="GET">
                        <div class="header__search-box">
                            <input class="search-input" name="product_name" id="findProduct" onfocus="showSearchResult()" onblur="hideSearchResult()" type="text" placeholder="I'm shopping for..."  value="{{request('product_name')}}">
                            <button class="button" type="submit"><i class="far fa-search"></i></button>
                        </div>
                        <div class="header__search-cat">
                            @php
                            $categories = App\Models\Category::where('status', 'Yes')->get();
                            @endphp
                            <select>
                                <option value="ALL" {{ request('category') == "All" ? 'selected' : '' }}>All Categories</option>
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}" {{ request('category') == $category->id ? 'selected' : '' }}>{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    <div class="search_result">
                        <ul id="suggest_products">

                        </ul>
                    </div>
                </div>
                <div class="mobile-menu fix"></div>
                <div class="offcanvas__action">

                </div>
            </div>
        </div>
    </div>
    <!-- offcanvas area end -->

    <div class="body-overlay"></div>

    <main>

        <!-- Body Contant Start -->
        @yield('body_content')
        <!-- Body Contant End -->

        @auth
            <input type="hidden" id="login_status" value="yes">

            @if (auth()->user()->email_verified_at == NULL)
            <input type="hidden" id="verified_status" value="no">
            @else
            <input type="hidden" id="verified_status" value="yes">
            @endif
        @else
            <input type="hidden" id="login_status" value="no">
        @endauth

        <!-- Quick View Modal Start -->
        <div class="modal fade" id="quickViewProductModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered product__modal" role="document" id="modal_content">
                <!-- Content will be lodded ajax -->
            </div>
        </div>
        <!-- Quick View Modal End -->

        <!-- Contact-area-start -->
        <section class="cta-area d-ldark-bg pt-55 pb-10">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="cta-item cta-item-d mb-30">
                            <h5 class="cta-title">Follow Us</h5>
                            <p>We make consolidating, marketing and tracking your social media website easy.</p>
                            <div class="cta-social">
                                <div class="social-icon">
                                    <a target="_blank" href="{{$default_setting->facebook_link}}" class="facebook"><i class="fab fa-facebook-f"></i></a>
                                    <a target="_blank" href="{{$default_setting->twitter_link}}" class="twitter"><i class="fab fa-twitter"></i></a>
                                    <a target="_blank" href="{{$default_setting->instagram_link}}" class="instagram"><i class="fab fa-instagram"></i></a>
                                    <a target="_blank" href="{{$default_setting->linkedin_link}}" class="linkedin"><i class="fab fa-linkedin-in"></i></a>
                                    <a target="_blank" href="{{$default_setting->youtube_link}}" class="youtube"><i class="fab fa-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="cta-item mb-30">
                            <h5 class="cta-title">Sign Up To Newsletter</h5>
                            <p>Join subscribers and get a new discount coupon.</p>
                            <div class="subscribe__form">
                                <form method="POST" action="{{route('subscribe.post')}}" id="subscribe_form">
                                    @csrf
                                    <input type="email" name="subscriber_email" placeholder="Enter your email here...">
                                    <button type="submit">subscribe</button>
                                    <span class="text-danger error-text subscriber_email_error"></span>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="cta-item mb-30">
                            <h5 class="cta-title">Download App</h5>
                            <p>App is now available on Google Play. Get it now.</p>
                            <div class="cta-apps">
                                <div class="apps-store">
                                    <a target="_blank" href="{{route('index')}}"><img src="{{asset('frontend')}}/img/app_android.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Contact-area-end -->
    </main>

    <!-- footer-start -->
    <footer>
        <div class="fotter-area d-dark-bg">
            <div class="footer__top pt-80 pb-15">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-4 order-last-md">
                            @php
                                $page_settings = App\Models\Page_setting::where('status', "Yes")->get();
                            @endphp
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="footer__widget">
                                        <div class="footer__widget-title">
                                            <h4>Quick Links</h4>
                                        </div>
                                        <div class="footer__widget-content">
                                            <div class="footer__link">
                                                <ul>
                                                    @foreach ($page_settings->where('page_position', 1) as $page)
                                                    <li><a href="{{ route('page', $page->page_slug) }}">{{ $page->page_name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="footer__widget">
                                        <div class="footer__widget-title">
                                            <h4>Quick Links</h4>
                                        </div>
                                        <div class="footer__widget-content">
                                            <div class="footer__link">
                                                <ul>
                                                    @foreach ($page_settings->where('page_position', 2) as $page)
                                                    <li><a href="{{ route('page', $page->page_slug) }}">{{ $page->page_name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-8 order-first-md">
                            <div class="footer__top-left">
                                <div class="row">
                                    <div class="col-xl-7 col-lg-6 col-md-6 col-sm-6">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                <div class="footer__widget">
                                                    <div class="footer__widget-title">
                                                        <h4>Quick Links</h4>
                                                    </div>
                                                    <div class="footer__widget-content">
                                                        <div class="footer__link">
                                                            <ul>
                                                                @foreach ($page_settings->where('page_position', 3) as $page)
                                                                <li><a href="{{ route('page', $page->page_slug) }}">{{ $page->page_name }}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                <div class="footer__widget">
                                                    <div class="footer__widget-title">
                                                        <h4>Quick Links</h4>
                                                    </div>
                                                    <div class="footer__widget-content">
                                                        <div class="footer__link">
                                                            <ul>
                                                                @foreach ($page_settings->where('page_position', 4) as $page)
                                                                <li><a href="{{ route('page', $page->page_slug) }}">{{ $page->page_name }}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-5 col-lg-6 col-md-6 col-sm-6">
                                        <div class="footer__widget">
                                            <div class="footer__widget-title mb-20">
                                                <h4>About The Store</h4>
                                            </div>
                                            <div class="footer__widget-content">
                                                <p class="footer-text mb-35">Our mission statement is to provide the
                                                    absolute best customer experience available in the Electronic
                                                    industry without exception.</p>
                                                <div class="footer__hotline d-flex align-items-center mb-10">
                                                    <div class="icon mr-15">
                                                        <i class="fal fa-headset"></i>
                                                    </div>
                                                    <div class="text">
                                                        <h4>Got Question? Call us 24/7!</h4>
                                                        <span><a href="tel:{{$default_setting->support_phone}}">{{$default_setting->support_phone}}</a></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer__bottom">
                <div class="container">
                    <div class="footer__bottom-content pt-55 pb-45">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="payment-image text-center mb-25">
                                    <a href="{{route('index')}}"><img class="w-100 img-fluid" src="{{asset('frontend')}}/img/payment.png" alt=""></a>
                                </div>
                                <div class="copy-right-area text-center">
                                    <p>Copyright © <span>{{date('Y')}}.</span> All Rights Reserved. Powered by <a target="_blank" href="{{ route('index') }}"><span class="main-color">{{ env('APP_NAME') }}.</span></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer-end -->

    <!-- JS here -->
    <script src="{{asset('frontend')}}/js/vendor/jquery.js"></script>
    <script src="{{asset('frontend')}}/js/vendor/waypoints.js"></script>
    <script src="{{asset('frontend')}}/js/select2.min.js"></script>
    <script src="{{asset('frontend')}}/js/bootstrap-bundle.js"></script>
    <script src="{{asset('frontend')}}/js/meanmenu.js"></script>
    <script src="{{asset('frontend')}}/js/swiper-bundle.js"></script>
    <script src="{{asset('frontend')}}/js/tweenmax.js"></script>
    <script src="{{asset('frontend')}}/js/owl-carousel.js"></script>
    <script src="{{asset('frontend')}}/js/magnific-popup.js"></script>
    <script src="{{asset('frontend')}}/js/parallax.js"></script>
    <script src="{{asset('frontend')}}/js/backtotop.js"></script>
    <script src="{{asset('frontend')}}/js/nice-select.js"></script>
    <script src="{{asset('frontend')}}/js/countdown.min.js"></script>
    <script src="{{asset('frontend')}}/js/counterup.js"></script>
    <script src="{{asset('frontend')}}/js/wow.js"></script>
    <script src="{{asset('frontend')}}/js/isotope-pkgd.js"></script>
    <script src="{{asset('frontend')}}/js/imagesloaded-pkgd.js"></script>
    <script src="{{asset('frontend')}}/js/ajax-form.js"></script>
    <script src="{{asset('frontend')}}/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('frontend')}}/js/sweetalert2@11.js"></script>
    <script src="{{asset('frontend')}}/js/main.js"></script>
    <!-- Scripts -->

    @yield('custom_script')

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // subscribe_form
            $("#subscribe_form").on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url:$(this).attr('action'),
                    method:$(this).attr('method'),
                    data:new FormData(this),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                        $(document).find('span.error-text').text('');
                    },
                    success:function(data){
                        if(data.status == 400){
                            $.each(data.error, function(prefix, val){
                                $('span.'+prefix+'_error').text(val[0]);
                            })
                        }else{
                            $('#subscribe_form')[0].reset();
                            const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-center',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                            })
                            Toast.fire({
                            icon: 'success',
                            title: 'Subscribe successfully'
                            })
                        }
                    }
                });
            })

            // Read Header Cart Data
            fetchHeaderCart();
            function fetchHeaderCart(){
                $.ajax({
                    url: '{{ route('fetch.header.cart') }}',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#header_cart_data').html(response.cart_data);
                        $('#header_cart_count').html(response.cart_count);
                        $('.header_cart_sub_total').html(response.cart_sub_total);
                    }
                });
            }

            // Read Card Data
            function fetchAllCart(){
                $.ajax({
                    url: "{{ route('fetch.cart') }}",
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#all_cart_data').html(response.carts_data);
                        $('#sub_total').html(response.carts_sub_total);
                        $('#grand_total').html(response.grand_total);
                        if(response.grand_total != 0){
                            $('#checkout_btn').removeClass('d-none');
                        }else{
                            $('#checkout_btn').addClass('d-none');
                        }
                    }
                });
            }

            // Cart Item Delete
            $(document).on('click', '.deleteHeaderCartBtn', function(e){
                e.preventDefault();
                let id = $(this).attr('id');
                var url = "{{ route('cart.forcedelete', ":id") }}";
                url = url.replace(':id', id)
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'GET',
                            success: function(response) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-center',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    }
                                })
                                Toast.fire({
                                    icon: 'warning',
                                    title: 'Cart item delete successfully'
                                })
                                fetchHeaderCart();
                                fetchAllCart();
                            }
                        });
                    }
                })
            })

            // Quick View Product
            $(document).on('click', '.quickViewProductBtn', function(e){
                e.preventDefault();
                var id = $(this).attr('id');
                var url = "{{ route('quick.view.product', ":id") }}";
                url = url.replace(':id', id)
                $.ajax({
                    url:  url,
                    method: 'GET',
                    success: function(response) {
                        $("#modal_content").html(response);
                        var color_count = $('.model_color_count').val();
                        if(color_count == 1){
                            $('.model_select_color').trigger('click');
                        }
                    }
                });
            })

            // Get Product Size
            $(document).on('click', '.model_select_color', function(e){
                e.preventDefault();
                var color_id = $(this).attr('id');
                var product_id = $('#model_product_id').val();
                $('#model_color_id').val(color_id);
                $('#model_size_id').val("");
                // ajax start
                $.ajax({
                    type: 'POST',
                    url: "{{route('get.sizes')}}",
                    data: {
                        color_id: color_id,
                        product_id: product_id
                    },

                    success: function (data) {
                        $('.model_sizes_data').html(data.model_send_sizes);
                        $('.model_available_qty').html(data.send_qty);
                        $('#model_sizes_count').val(data.sizes_count);
                    }
                })
                // ajax end
            });

            // Get Product QTY
            $(document).on('click', '.model_select_size', function(e){
                e.preventDefault();
                var size_id = $(this).attr('id');
                $('#model_size_id').val('');
                $('#model_size_id').val(size_id);
                var color_id = $('#model_color_id').val();
                var product_id = $('#model_product_id').val();
                // ajax start
                $.ajax({
                    type: 'POST',
                    url: "{{route('get.quantity')}}",
                    data: {
                        color_id: color_id,
                        product_id: product_id,
                        size_id: size_id
                    },

                    success: function (data) {
                        $('.model_available_qty').html(data.send_qty);
                    }
                })
                // ajax end
            })

            // Product Buy Now
            $(document).on('click', '.buyNowBtn', function(e){
                e.preventDefault();
                var size_count = $('#model_sizes_count').val();
                if(size_count == 1){
                    $('.model_select_size').trigger('click');
                }
                if ($('#login_status').val() == 'no') {
                    Swal.fire({
                        title: 'You are not log in!',
                        text: "Please login first.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Go to login.'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{route('login')}}"
                        }
                    })
                }
                else {
                    if ($('#verified_status').val() == 'no') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'You are not verified user!',
                            text: 'Please go to your email and verified your account.',
                        })
                    } else {
                        var available_qty = parseInt($('.model_available_qty').html());
                        var cart_qty = parseInt($('#cart_qty').val());
                        if (cart_qty > available_qty) {
                            Swal.fire(
                                'Stock not available this qty!',
                                'Please select available qty.',
                                'warning'
                            )
                        } else {
                            var color_id = $('#model_color_id').val();
                            var size_id = $('#model_size_id').val();
                            if (color_id == 0) {
                                Swal.fire(
                                    'Please select color first',
                                    'Importent!',
                                    'warning'
                                )
                            } else {
                                if (size_id == 0) {
                                    Swal.fire(
                                        'Please select size!',
                                        'Importent!',
                                        'warning'
                                    )
                                } else {
                                    var cart_qty = $('#cart_qty').val();
                                    if (cart_qty <= 0) {
                                        Swal.fire(
                                            'Please select QTY!',
                                            'Importent!',
                                            'warning'
                                        )
                                    } else {
                                        var product_id = $('#model_product_id').val();
                                        var product_current_price = $('#product_discounted_price').val();
                                        var size_id = $('#model_size_id').val();
                                        var color_id = $('#model_color_id').val();
                                        var cart_qty = $('#cart_qty').val();
                                        var user_id = "{{ auth()->id() }}"

                                        // ajax start
                                        $.ajax({
                                            type: 'POST',
                                            url: "{{route('buy.now')}}",
                                            data: {
                                                product_id: product_id,
                                                product_current_price: product_current_price,
                                                color_id: color_id,
                                                size_id: size_id,
                                                cart_qty: cart_qty,
                                                user_id: user_id
                                            },
                                            success: function (data) {
                                                const Toast = Swal.mixin({
                                                    toast: true,
                                                    position: 'top-center',
                                                    showConfirmButton: false,
                                                    timer: 3000,
                                                    timerProgressBar: true,
                                                    didOpen: (toast) => {
                                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                                    }
                                                })
                                                Toast.fire({
                                                    icon: 'success',
                                                    title: 'Product select successfully'
                                                })

                                                var url = "{{ route('checkout') }}";
                                                window.location.href = url;
                                            }
                                        })
                                        // ajax end
                                    }
                                }
                            }
                        }
                    }
                }
            });

            // Product Add To Cart
            $(document).on('click', '.addToCartBtn', function(e){
                e.preventDefault();
                var size_count = $('#model_sizes_count').val();
                if(size_count == 1){
                    $('.model_select_size').trigger('click');
                }
                if ($('#login_status').val() == 'no') {
                    Swal.fire({
                        title: 'You are not log in!',
                        text: "Please login first.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Go to login.'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{route('login')}}"
                        }
                    })
                }
                else {
                    if ($('#verified_status').val() == 'no') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'You are not verified user!',
                            text: 'Please go to your email and verified your account.',
                        })
                    } else {
                        var available_qty = parseInt($('.model_available_qty').html());
                        var cart_qty = parseInt($('#cart_qty').val());
                        if (cart_qty > available_qty) {
                            Swal.fire(
                                'Stock not available this qty!',
                                'Please select available qty.',
                                'warning'
                            )
                        } else {
                            var color_id = $('#model_color_id').val();
                            var size_id = $('#model_size_id').val();
                            if (color_id == 0) {
                                Swal.fire(
                                    'Please select color first',
                                    'Importent!',
                                    'warning'
                                )
                            } else {
                                if (size_id == 0) {
                                    Swal.fire(
                                        'Please select size!',
                                        'Importent!',
                                        'warning'
                                    )
                                } else {
                                    var cart_qty = $('#cart_qty').val();
                                    if (cart_qty <= 0) {
                                        Swal.fire(
                                            'Please select QTY!',
                                            'Importent!',
                                            'warning'
                                        )
                                    } else {
                                        var product_id = $('#model_product_id').val();
                                        var product_current_price = $('#product_discounted_price').val();
                                        var size_id = $('#model_size_id').val();
                                        var color_id = $('#model_color_id').val();
                                        var cart_qty = $('#cart_qty').val();
                                        var user_id = "{{ auth()->id() }}"

                                        // ajax start
                                        $.ajax({
                                            type: 'POST',
                                            url: "{{route('insert.cart')}}",
                                            data: {
                                                product_id: product_id,
                                                product_current_price: product_current_price,
                                                color_id: color_id,
                                                size_id: size_id,
                                                cart_qty: cart_qty,
                                                user_id: user_id
                                            },
                                            success: function (data) {
                                                if (data.status == 200) {
                                                    $('#header_cart_count').html(data.cart_qty_status + parseInt($('#header_cart_count').html()));
                                                    const Toast = Swal.mixin({
                                                        toast: true,
                                                        position: 'top-center',
                                                        showConfirmButton: false,
                                                        timer: 3000,
                                                        timerProgressBar: true,
                                                        didOpen: (toast) => {
                                                            toast.addEventListener('mouseenter', Swal.stopTimer)
                                                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                                                        }
                                                    })
                                                    Toast.fire({
                                                        icon: 'success',
                                                        title: 'Product Added successfully in Cart'
                                                    })
                                                    fetchHeaderCart();
                                                } else {
                                                    $('#header_cart_count').html(data.cart_qty_status + parseInt($('#header_cart_count').html()));
                                                    const Toast = Swal.mixin({
                                                        toast: true,
                                                        position: 'top-center',
                                                        showConfirmButton: false,
                                                        timer: 3000,
                                                        timerProgressBar: true,
                                                        didOpen: (toast) => {
                                                            toast.addEventListener('mouseenter', Swal.stopTimer)
                                                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                                                        }
                                                    })
                                                    Toast.fire({
                                                        icon: 'warning',
                                                        title: 'This Product Already Added in Cart'
                                                    })
                                                }
                                            }
                                        })
                                        // ajax end
                                    }
                                }
                            }
                        }
                    }
                }
            });

            // Product Add To Wishlist
            $(document).on('click', '.addToWishlistBtn', function(e){
                e.preventDefault();
                if ($('#login_status').val() == 'no') {
                    Swal.fire({
                        title: 'You are not log in!',
                        text: "Please login first.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Go to login.'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{route('login')}}"
                        }
                    })
                } else {
                    if ($('#verified_status').val() == 'no') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'You are not verified user!',
                            text: 'Please go to your email and verified your account.',
                        })
                    } else {
                        var product_id = $(this).attr('id');
                        var user_id = "{{ auth()->id() }}";
                        // ajax start
                        $.ajax({
                            type: 'POST',
                            url: "{{route('insert.wishlist')}}",
                            data: {
                                product_id: product_id,
                                user_id: user_id
                            },
                            success: function (data) {
                                if (data.status == 200) {
                                    $('#header_wishlist_num').html(data.wishlist_qty_status + parseInt($('#header_wishlist_num').html()));
                                        const Toast = Swal.mixin({
                                            toast: true,
                                            position: 'top-center',
                                            showConfirmButton: false,
                                            timer: 3000,
                                            timerProgressBar: true,
                                            didOpen: (toast) => {
                                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                                            }
                                        })
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Product Added successfully in Wishlist'
                                        })
                                } else {
                                    $('#header_wishlist_num').html(data.wishlist_qty_status + parseInt($('#header_wishlist_num').html()));
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: 'top-center',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.addEventListener('mouseenter', Swal.stopTimer)
                                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                                        }
                                    })
                                    Toast.fire({
                                        icon: 'warning',
                                        title: 'This Product Already Added in Wishlist'
                                    })
                                }
                            }
                        })
                        // ajax end
                    }
                }
            })

            // Find Product
            $('#findProduct').keyup(function(){
                var searchData = $("#findProduct").val();
                if(searchData.length > 0){
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });
                    $.ajax({
                        type:'POST',
                        url: "{{route('find.product')}}",
                        data:{search:searchData},

                        success: function(result){
                            $('#suggest_products').html(result)
                        }
                    })
                    // ajax end
                }
                if(searchData.length < 1) {
                    $('#suggest_products').html("")
                }
            })
        });

        // Find Product
        function showSearchResult(){
            $('#suggest_products').slideDown()
        }
        function hideSearchResult(){
            $('#suggest_products').slideUp()
        }
    </script>

</body>

</html>
