@extends('frontend.layouts.frontend_master')

@section('title_bar')
eCommerce | Home
@endsection

@section('body_content')
<!-- slider-area-start -->
<div class="slider-area">
    <div class="swiper-container slider__active">
        <div class="slider-wrapper swiper-wrapper">
            @forelse ($sliders as $slider)
            <div class="single-slider swiper-slide slider-height d-flex align-items-center"
                data-background="{{asset('uploads/slider_photo')}}/{{$slider->slider_photo}}">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5">
                            <div class="slider-content">
                                <div class="slider-top-btn" data-animation="fadeInLeft" data-delay="1.5s">
                                    <span class="st-btn b-radius">HOT DEALS</span>
                                </div>
                                <h2 data-animation="fadeInLeft" data-delay="1.7s" class="pt-15 slider-title pb-5">
                                    {{$slider->slider_title}}</h2>
                                <p class="pr-20 slider_text" data-animation="fadeInLeft" data-delay="1.9s">
                                    {{$slider->slider_subtitle}}</p>
                                <div class="slider-bottom-btn mt-75">
                                    @php
                                        $flashsale = App\Models\Flashsale::where('flashsale_offer_slug', $slider->slider_link)->first();
                                    @endphp
                                    @if ($flashsale->status == "Yes" && $flashsale->flashsale_offer_start_date > Carbon\Carbon::now() )
                                        <span class="st-btn-b b-radius">Coming Soon</span>
                                    @elseif ($flashsale->status == "Yes" && $flashsale->flashsale_offer_start_date < Carbon\Carbon::now() && $flashsale->flashsale_offer_end_date > Carbon\Carbon::now())
                                        <a data-animation="fadeInUp" data-delay="1.15s" href="{{route('flashsale.product', $slider->slider_link)}}"
                                        class="st-btn-b b-radius">Shopping Now</a>
                                    @else
                                        <span class="st-btn-b b-radius">Offer End</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /single-slider -->
            @empty
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="alert alert-warning text-center" role="alert">
                            <strong>Slider Item Not Found!</strong>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
            <div class="main-slider-paginations"></div>
        </div>
    </div>
</div>
<!-- slider-area-end -->

<!-- features__area-start -->
<section class="features__area pt-20">
    <div class="container">
        <div class="row row-cols-xxl-4 row-cols-xl-4 row-cols-lg-4 row-cols-md-2 row-cols-sm-2 row-cols-1 gx-0">
            @forelse ($features as $feature)
            <div class="col">
                <div class="features__item d-flex white-bg {{($loop->last == 1) ? 'features__item-last' : ''}}">
                    <div class="features__icon mr-20">
                        <img width="50" height="50" src="{{asset('uploads/feature_photo')}}/{{$feature->feature_photo}}"
                            alt="">
                    </div>
                    <div class="features__content">
                        <h6>{{$feature->feature_title}}</h6>
                        <p>{{$feature->feature_subtitle}}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="alert alert-warning text-center" role="alert">
                            <strong>Feature Item Not Found!</strong>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>
<!-- features__area-end -->

<!-- Products For You Area Start -->
<section class="topsell__area-1 pt-15">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section__head d-flex justify-content-between mb-10">
                    <div class="section__title">
                        <h5 class="st-titile">Products For You</h5>
                    </div>
                    <div class="button-wrap">
                        <a href="{{route('all.product')}}">See All Product <i class="fal fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="product-bs-slider">
                <div class="product-slider swiper-container">
                    <div class="swiper-wrapper">
                        @forelse ($random_products as $product)
                        @include('frontend.part.product')
                        @empty
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="alert alert-warning text-center" role="alert">
                                        <strong>Products For You Item Not Found!</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
                <!-- If we need navigation buttons -->
                <div class="bs-button bs-button-prev"><i class="fal fa-chevron-left"></i></div>
                <div class="bs-button bs-button-next"><i class="fal fa-chevron-right"></i></div>
            </div>
        </div>
    </div>
</section>
<!-- Products For You Area End -->

<!-- Top_banner__area-start -->
<section class="banner__area pt-20 pb-10">
    <div class="container">
        <div class="row">
            @forelse($banners->where('banner_position', 'Top') as $banner)
            @php
                $banner_link = App\Models\Product::find($banner->banner_link)->product_slug
            @endphp
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="banner__item p-relative w-img mb-30">
                    <div class="banner__img">
                        <a href="{{route('product.details', $banner_link)}}"><img
                                src="{{asset('uploads/banner_photo')}}/{{$banner->banner_photo}}" alt=""></a>
                    </div>
                    <div class="banner__content">
                        <h6><a href="{{route('product.details', $banner_link)}}">{{$banner->banner_title}}</a></h6>
                        <p>{{$banner->banner_subtitle}}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="alert alert-warning text-center" role="alert">
                            <strong>Banner Item Not Found!</strong>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>
<!-- Top_banner__area-end -->

<!-- today__deal__area-start -->
<section class="topsell__area-1 pt-15 pb-20">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section__head d-flex justify-content-between mb-10">
                    <div class="section__title">
                        <h5 class="st-titile-d">Today Deal</h5>
                    </div>
                    <div class="offer-time">
                        <span class="offer-title d-none d-sm-block">Hurry Up! Offer ends in:</span>
                        @if ($today_deal_products->count() > 0)
                        <div class="countdown">
                            <div class="countdown-inner b-radius" data-countdown=""
                                data-date="{{today()->format('M d y')}} 24:00:00">
                                <ul class="text-center">
                                    <li><span data-hours=""></span> Hours</li>
                                    <li><span data-minutes=""></span> Mins</li>
                                    <li><span data-seconds=""></span> Secs</li>
                                </ul>
                            </div>
                        </div>
                        @else
                        <div class="countdown">
                            <div class="countdown-inner b-radius" data-countdown=""
                                data-date="{{today()->format('M d y')}} 00:00:00">
                                <ul class="text-center">
                                    <li><span data-hours=""></span> Hours</li>
                                    <li><span data-minutes=""></span> Mins</li>
                                    <li><span data-seconds=""></span> Secs</li>
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="product-bs-slider">
                <div class="product-slider swiper-container">
                    <div class="swiper-wrapper">
                        @forelse ($today_deal_products as $product)
                        @include('frontend.part.product')
                        @empty
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="alert alert-warning text-center" role="alert">
                                        <strong>Today Deal Product Item Not Found!</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
                <!-- If we need navigation buttons -->
                <div class="bs-button bs-button-prev"><i class="fal fa-chevron-left"></i></div>
                <div class="bs-button bs-button-next"><i class="fal fa-chevron-right"></i></div>
            </div>
        </div>
    </div>
</section>
<!-- today__deal__area-end -->

<!-- Center_banner__area-start -->
<section class="banner__area banner__area-d pt-15 pb-10">
    <div class="container">
        <div class="row">
            @forelse($banners->where('banner_position', 'Center') as $banner)
            @php
                $banner_link = App\Models\Product::find($banner->banner_link)->product_slug
            @endphp
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="banner__item p-relative w-img mb-30">
                    <div class="banner__img">
                        <a href="{{route('product.details', $banner_link)}}"><img
                                src="{{asset('uploads/banner_photo')}}/{{$banner->banner_photo}}" alt=""></a>
                    </div>
                    <div class="banner__content">
                        <span>Bestseller Products</span>
                        <h6><a href="{{route('product.details', $banner_link)}}">{{$banner->banner_title}}</a></h6>
                        <p>{{$banner->banner_subtitle}}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="alert alert-warning text-center" role="alert">
                            <strong>Banner Item Not Found!</strong>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>
<!-- Center_banner__area-end -->

<!-- Category Wise Products Area Start -->
<section class="topsell__area-2 pt-15 pb-30">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section__head d-flex justify-content-between mb-10">
                    <div class="section__title">
                        <h5 class="st-titile">Category Wise Products</h5>
                    </div>
                    <div class="product__nav-tab">
                        <ul class="nav nav-tabs" id="flast-sell-tab" role="tablist">
                            @foreach ($categories->where('show_home_screen', 'Yes') as $category)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{($loop->first == 1) ? 'active' : ''}}"
                                    id="{{$category->category_slug}}-tab" data-bs-toggle="tab"
                                    data-bs-target="#{{$category->category_slug}}" type="button" role="tab"
                                    aria-controls="{{$category->category_slug}}"
                                    aria-selected="false">{{$category->category_name}}</button>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="tab-content" id="flast-sell-tabContent">
                    @forelse ($categories->where('show_home_screen', 'Yes') as $category)
                    <div class="tab-pane fade {{($loop->first == 1) ? 'active show' : ''}}"
                        id="{{$category->category_slug}}" role="tabpanel"
                        aria-labelledby="{{$category->category_slug}}-tab">
                        <div class="product-bs-slider-2">
                            <div class="product-slider-2 swiper-container">
                                <div class="swiper-wrapper">
                                    @forelse ($products->where('category_id', $category->id) as $product)
                                    @include('frontend.part.product')
                                    @empty
                                    <span class="text-danger">Product Not Found</span>
                                    @endforelse
                                </div>
                            </div>
                            <!-- If we need navigation buttons -->
                            <div class="bs-button bs2-button-prev"><i class="fal fa-chevron-left"></i></div>
                            <div class="bs-button bs2-button-next"><i class="fal fa-chevron-right"></i></div>
                        </div>
                    </div>
                    @empty
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="alert alert-warning text-center" role="alert">
                                    <strong>Category Wise Product Item Not Found!</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Category Wise Products Area End -->

<!-- Top Selling Products Area Start -->
<section class="featured light-bg pt-25 pb-20">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section__head d-flex justify-content-between mb-30">
                    <div class="section__title">
                        <h5 class="st-titile">Top Selling Products</h5>
                    </div>
                    <div class="button-wrap">
                        <a href="{{route('all.product')}}">See All Product <i class="fal fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            @forelse ($top_selling_products as $product)
            @php
                $flashsale = App\Models\Flashsale::where('id', $product->flashsale_id)->first()
            @endphp
            @if ($loop->first == 1)
            <div class="col-xl-5 col-lg-12">
                <div class="single-features-item single-features-item-d b-radius mb-20">
                    <div class="row  g-0 align-items-center">
                        <div class="col-md-6">
                            <div class="features-thum">
                                <div class="features-product-image w-img">
                                    <a href="{{route('product.details', $product->product_slug)}}"><img
                                            src="{{asset('uploads/product_thumbnail_photo')}}/{{$product->product_thumbnail_photo}}"
                                            alt=""></a>
                                </div>
                                @if (App\Models\Product_inventory::where('product_id', $product->id)->sum('quantity') ==
                                0)
                                <div class="product__offer">
                                    <span class="discount">Stock Out</span>
                                </div>
                                @else
                                    @if ($product->discounted_price != $product->regular_price)
                                    <div class="product__offer">
                                        @if ($product->flashsale_status == "Yes")
                                            @if ($flashsale->status == "Yes" && $flashsale->flashsale_offer_start_date < Carbon\Carbon::now() && $flashsale->flashsale_offer_end_date > Carbon\Carbon::now())
                                                <span class="discount">{{100-round((($product->regular_price - ($product->regular_price*($flashsale->flashsale_offer_amount/100)))/$product->regular_price) * 100, 1)}}% OFF</span>
                                            @else
                                                <span class="discount">{{100-round(($product->discounted_price/$product->regular_price) * 100, 1)}}% OFF</span>
                                            @endif
                                        @else
                                            <span class="discount">{{100-round(($product->discounted_price/$product->regular_price) * 100, 1)}}% OFF</span>
                                        @endif
                                    </div>
                                    @endif
                                @endif
                                <div class="product-action">
                                    <a href="#" class="icon-box icon-box-1 quickViewProductBtn" id="{{$product->id}}"
                                        data-bs-toggle="modal" data-bs-target="#quickViewProductModal">
                                        <i class="fal fa-eye"></i>
                                        <i class="fal fa-eye"></i>
                                    </a>
                                    <a href="#" class="icon-box icon-box-1 addToWishlistBtn" id="{{$product->id}}">
                                        <i class="fal fa-heart"></i>
                                        <i class="fal fa-heart"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="cart-option mt-2">
                                <a href="#" class="cart-btn-2 w-100 mr-10 quickViewProductBtn" id="{{$product->id}}"
                                    data-bs-toggle="modal" data-bs-target="#quickViewProductModal">Add to Cart</a>
                                <a href="#" class="transperant-btn addToWishlistBtn" id="{{$product->id}}">
                                    <i class="fal fa-heart"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="product__content product__content-d p-3">
                                <h6><a href="{{route('product.details', $product->product_slug)}}">{{$product->product_name}}</a>
                                </h6>
                                @php
                                    $product_reviews = App\Models\Review::where('product_id', $product->id)->get();
                                @endphp
                                <div class="rating mb-5">
                                    <ul class="rating-d">
                                        @if ($product_reviews->average('rating'))
                                            @for ($star = 0; $star < round($product_reviews->average('rating')); $star++)
                                            <li><i class="fa fa-star"></i></li>
                                            @endfor
                                            @for ($star = 0; $star < 5-round($product_reviews->average('rating')); $star++)
                                            <li><i class="fal fa-star"></i></li>
                                            @endfor
                                        @else
                                            <li><i class="fal fa-star"></i></li>
                                            <li><i class="fal fa-star"></i></li>
                                            <li><i class="fal fa-star"></i></li>
                                            <li><i class="fal fa-star"></i></li>
                                            <li><i class="fal fa-star"></i></li>
                                        @endif
                                    </ul>
                                    <span>({{ $product_reviews->count() }} review)</span>
                                </div>
                                <div class="price d-price">
                                    <span class="text-danger"><del>৳ {{$product->regular_price}}</del></span>
                                    @if ($product->flashsale_status == "Yes")
                                        @if ($flashsale->status == "Yes" && $flashsale->flashsale_offer_start_date < Carbon\Carbon::now() && $flashsale->flashsale_offer_end_date > Carbon\Carbon::now())
                                            @if($flashsale->flashsale_offer_type == 'Percentage')
                                            ৳ {{ $product->regular_price - ($product->regular_price*($flashsale->flashsale_offer_amount/100)) }}
                                            @else
                                            ৳ {{ $product->regular_price - $flashsale->flashsale_offer_amount }}
                                            @endif
                                        @else
                                            ৳ {{$product->discounted_price}}
                                        @endif
                                    @else
                                    ৳ {{$product->discounted_price}}
                                    @endif
                                </div>
                                <div class="features-des mb-25">
                                    {!! Str::words($product->short_description, 15, '...') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @empty
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="alert alert-warning text-center" role="alert">
                            <strong>Top Selling Product Item Not Found!</strong>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
            <div class="col-xl-7 col-lg-12">
                <div class="row d-flex align-items-center">
                    @foreach ($top_selling_products as $product)
                    @php
                        $flashsale = App\Models\Flashsale::where('id', $product->flashsale_id)->first()
                    @endphp
                    @if ($loop->first != 1)
                    <div class="col-md-6">
                        <div class="single-features-item b-radius mb-20">
                            <div class="row  g-0 align-items-center">
                                <div class="col-6">
                                    <div class="features-thum">
                                        <div class="features-product-image w-img">
                                            <a href="{{route('product.details', $product->product_slug)}}"><img
                                                    src="{{asset('uploads/product_thumbnail_photo')}}/{{$product->product_thumbnail_photo}}"
                                                    alt=""></a>
                                        </div>
                                        @if (App\Models\Product_inventory::where('product_id', $product->id)->sum('quantity') == 0)
                                        <div class="product__offer">
                                            <span class="discount">Stock Out</span>
                                        </div>
                                        @else
                                            @if ($product->discounted_price != $product->regular_price)
                                            <div class="product__offer">
                                                @if ($product->flashsale_status == "Yes")
                                                    @if ($flashsale->status == "Yes" && $flashsale->flashsale_offer_start_date < Carbon\Carbon::now() && $flashsale->flashsale_offer_end_date > Carbon\Carbon::now())
                                                        <span class="discount">{{100-round((($product->regular_price - ($product->regular_price*($flashsale->flashsale_offer_amount/100)))/$product->regular_price) * 100, 1)}}% OFF</span>
                                                    @else
                                                        <span class="discount">{{100-round(($product->discounted_price/$product->regular_price) * 100, 1)}}% OFF</span>
                                                    @endif
                                                @else
                                                    <span class="discount">{{100-round(($product->discounted_price/$product->regular_price) * 100, 1)}}% OFF</span>
                                                @endif
                                            </div>
                                            @endif
                                        @endif
                                        <div class="product-action">
                                            <a href="#" class="icon-box icon-box-1 quickViewProductBtn"
                                                id="{{$product->id}}" data-bs-toggle="modal"
                                                data-bs-target="#quickViewProductModal">
                                                <i class="fal fa-eye"></i>
                                                <i class="fal fa-eye"></i>
                                            </a>
                                            <a href="#" class="icon-box icon-box-1 addToWishlistBtn"
                                                id="{{$product->id}}">
                                                <i class="fal fa-heart"></i>
                                                <i class="fal fa-heart"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="product__content product__content-d p-2">
                                        <h6><a href="{{route('product.details', $product->product_slug)}}">{{$product->product_name}}</a>
                                        </h6>
                                        <div class="rating mb-5">
                                            @php
                                                $product_reviews = App\Models\Review::where('product_id', $product->id)->get();
                                            @endphp
                                            <ul>
                                            @if ($product_reviews->average('rating'))
                                                @for ($star = 0; $star < round($product_reviews->average('rating')); $star++)
                                                <li><i class="fa fa-star"></i></li>
                                                @endfor
                                                @for ($star = 0; $star < 5-round($product_reviews->average('rating')); $star++)
                                                <li><i class="fal fa-star"></i></li>
                                                @endfor
                                            @else
                                                <li><i class="fal fa-star"></i></li>
                                                <li><i class="fal fa-star"></i></li>
                                                <li><i class="fal fa-star"></i></li>
                                                <li><i class="fal fa-star"></i></li>
                                                <li><i class="fal fa-star"></i></li>
                                            @endif
                                            </ul>
                                        </div>
                                        <span>({{ $product_reviews->count() }} review)</span>
                                        <div class="price d-price">
                                            <span class="text-danger"><del>৳ {{$product->regular_price}}</del></span>
                                            @if ($product->flashsale_status == "Yes")
                                                @if ($flashsale->status == "Yes" && $flashsale->flashsale_offer_start_date < Carbon\Carbon::now() && $flashsale->flashsale_offer_end_date > Carbon\Carbon::now())
                                                    @if($flashsale->flashsale_offer_type == 'Percentage')
                                                    ৳ {{ $product->regular_price - ($product->regular_price*($flashsale->flashsale_offer_amount/100)) }}
                                                    @else
                                                    ৳ {{ $product->regular_price - $flashsale->flashsale_offer_amount }}
                                                    @endif
                                                @else
                                                    ৳ {{$product->discounted_price}}
                                                @endif
                                            @else
                                            ৳ {{$product->discounted_price}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Top Selling Products Area End -->

<!-- moveing-text-area-start -->
<section class="moveing-text-area">
    <div class="container">
        <div class="ovic-running">
            <div class="wrap">
                <div class="inner">
                    @forelse ($features as $feature)
                    <p class="item">{{$feature->feature_title}}</p>
                    @empty
                    <p class="item">{{ env('APP_NAME') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
<!-- moveing-text-area-end -->

<!-- Bottom_banner__area-start -->
<section class="banner__area pt-40 pb-25">
    <div class="container">
        <div class="row">
            @forelse($banners->where('banner_position', 'Bottom') as $banner)
            @php
                $banner_link = App\Models\Product::find($banner->banner_link)->product_slug
            @endphp
            @if ($loop->index == 0)
            <div class="col-xl-4 col-lg-6 col-md-12">
                <div class="banner__item p-relative w-img mb-30">
                    <div class="banner__img">
                        <a href="{{route('product.details', $banner_link)}}"><img width="450" height="450"
                                src="{{asset('uploads/banner_photo')}}/{{$banner->banner_photo}}" alt=""></a>
                    </div>
                    <div class="banner__content banner__content-sd text-center">
                        <div class="banner-button mb-20">
                            <a href="{{route('product.details', $banner_link)}}" class="st-btn">{{ $banner->banner_title }}</a>
                        </div>
                        <h6><a href="{{route('product.details', $banner_link)}}">{{ $banner->banner_subtitle }}</a></h6>
                    </div>
                </div>
            </div>
            @endif
            @empty
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="alert alert-warning text-center" role="alert">
                            <strong>Banner Item Not Found!</strong>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
            <div class="col-xl-4 col-lg-6 col-md-12">
                <div class="row">
                    @foreach($banners->where('banner_position', 'Bottom') as $banner)
                    @php
                        $banner_link = App\Models\Product::find($banner->banner_link)->product_slug
                    @endphp
                    @if ($loop->index != 0 && $loop->index != 3 )
                    <div class="col-md-12">
                        <div class="banner__item p-relative mb-30 w-img">
                            <div class="banner__img">
                                <a href="{{route('product.details', $banner_link)}}"><img width="450" height="210"
                                        src="{{asset('uploads/banner_photo')}}/{{$banner->banner_photo}}" alt=""></a>
                            </div>
                            <div class="banner__content banner__content-sd text-center">
                                <h6><a href="{{route('product.details', $banner_link)}}">{{ $banner->banner_title }}</a></h6>
                                <p>{{ $banner->banner_subtitle }}</p>
                                <div class="banner-button mt-20 d-none d-sm-block">
                                    <a href="{{route('product.details', $banner_link)}}" class="st-btn-3 b-radius">Shop Deals</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @foreach($banners->where('banner_position', 'Bottom') as $banner)
            @php
                $banner_link = App\Models\Product::find($banner->banner_link)->product_slug
            @endphp
            @if ($loop->index == 3)
            <div class="col-xl-4 col-lg-6 col-md-12">
                <div class="banner__item p-relative w-img mb-30">
                    <div class="banner__img">
                        <a href="{{route('product.details', $banner_link)}}"><img width="450" height="450"
                                src="{{asset('uploads/banner_photo')}}/{{$banner->banner_photo}}" alt=""></a>
                    </div>
                    <div class="banner__content banner__content-sd text-center">
                        <div class="banner-button mb-20">
                            <a href="{{route('product.details', $banner_link)}}" class="st-btn">{{ $banner->banner_title }}</a>
                        </div>
                        <h6><a href="{{route('product.details', $banner_link)}}">{{ $banner->banner_subtitle }}</a></h6>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>
<!-- Bottom_banner__area-end -->

<!-- top-view-product-area-start -->
<section class="recomand-product-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section__head d-flex justify-content-between mb-10">
                    <div class="section__title">
                        <h5 class="st-titile">Top View Products</h5>
                    </div>
                    <div class="button-wrap">
                        <a href="{{route('all.product')}}">See All Product <i class="fal fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-0">
            <div class="product-bs-slider-2">
                <div class="product-slider-3 swiper-container">
                    <div class="swiper-wrapper">
                        @forelse ($top_selling_products as $product)
                        @include('frontend.part.product')
                        @empty
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="alert alert-warning text-center" role="alert">
                                        <strong>Top View Product Item Not Found!</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- top-view-product-area-end -->

<!-- brand-area-start -->
<section class="brand-area brand-area-d">
    <div class="container">
        <div class="brand-slider swiper-container pt-50 pb-45">
            <div class="swiper-wrapper">
                @forelse ($brands as $brand)
                <div class="brand-item w-img swiper-slide">
                    <a href="{{ route('brand.wise.product', $brand->brand_slug) }}"><img width="170" height="40"
                            src="{{asset('uploads/brand_photo')}}/{{$brand->brand_photo}}"
                            alt="{{$brand->brand_name}}"></a>
                </div>
                @empty
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="alert alert-warning text-center" role="alert">
                                <strong>Brand Item Not Found!</strong>
                            </div>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
<!-- brand-area-end -->
@endsection

@section('custom_script')
<script>

</script>
@endsection
