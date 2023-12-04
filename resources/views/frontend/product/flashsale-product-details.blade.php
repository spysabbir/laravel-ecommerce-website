@extends('frontend.layouts.frontend_master')

@section('title_bar')
{{$product->product_name}}
@endsection

@section('body_content')
<!-- breadcrumb__area-start -->
<section class="breadcrumb__area box-plr-75">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12">
                <div class="breadcrumb__wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('all.product')}}">All Product</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$product->product_name}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb__area-end -->

<!-- product-details-start -->
<div class="product-details">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="product__details-nav d-sm-flex align-items-start">
                    <ul class="nav nav-tabs flex-sm-column justify-content-between" id="productThumbTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="thumb0-tab" data-bs-toggle="tab"
                                data-bs-target="#thumb0" type="button" role="tab" aria-controls="thumb0"
                                aria-selected="true">
                                <img width="85" height="85" src="{{asset('uploads/product_thumbnail_photo')}}/{{$product->product_thumbnail_photo}}" alt="">
                            </button>
                        </li>
                        @foreach ($product_featured_photos as $product_featured_photo)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="thumb{{$product_featured_photo->id}}-tab" data-bs-toggle="tab"
                                data-bs-target="#thumb{{$product_featured_photo->id}}" type="button" role="tab" aria-controls="thumb{{$product_featured_photo->id}}"
                                aria-selected="true">
                                <img width="85" height="85" src="{{asset('uploads/product_featured_photos')}}/{{$product_featured_photo->product_featured_photos}}" alt="">
                            </button>
                        </li>
                        @endforeach
                    </ul>
                    <div class="product__details-thumb">
                        <div class="tab-content" id="productThumbContent">
                            <div class="tab-pane fade show active" id="thumb0" role="tabpanel"
                                aria-labelledby="thumb0-tab">
                                <div class="product__details-nav-thumb w-img">
                                    <img width="600" height="600" src="{{asset('uploads/product_thumbnail_photo')}}/{{$product->product_thumbnail_photo}}" alt="">
                                </div>
                            </div>
                            @foreach ($product_featured_photos as $product_featured_photo)
                            <div class="tab-pane fade" id="thumb{{$product_featured_photo->id}}" role="tabpanel"
                                aria-labelledby="thumb{{$product_featured_photo->id}}-tab">
                                <div class="product__details-nav-thumb w-img">
                                    <img width="600" height="600" src="{{asset('uploads/product_featured_photos')}}/{{$product_featured_photo->product_featured_photos}}" alt="">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="product__details-content">
                    <h6>{{$product->product_name}}</h6>
                    <input type="hidden" value="{{ $product->id }}" id="details_product_id">
                    <div class="pd-rating mb-10">
                        <ul class="rating">
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
                    <div class="price mb-10">
                        <span class="text-danger"><del>৳ {{$product->regular_price}}</del></span>

                        @if($flashsale->flashsale_offer_type == 'Percentage')
                            <span class="text-success">৳ {{ $product_discounted_price = $product->regular_price - ($product->regular_price*($flashsale->flashsale_offer_amount/100)) }}</span>
                        @else
                            <span class="text-success">৳ {{ $product_discounted_price = $product->regular_price - $flashsale->flashsale_offer_amount }}</span>
                        @endif

                        <input type="hidden" value="{{$product_discounted_price}}" id="product_discounted_price">
                    </div>
                    <div class="features-des pb-5">
                        {!! $product->short_description !!}
                    </div>
                    @if ($sum_quantity_inventories != 0)
                    <div class="inventory mb-20 mt-10">
                        <div class="color-item mb-2 d-flex">
                            <input type="hidden" name="" value="" id="details_color_id">
                            <span>Color:</span>
                            @foreach ($product_inventories as $product_inventory)
                            <span id="{{$product_inventory->color_id}}" style="background-color: {{$product_inventory->relationtocolor->color_code}}" class="border details_select_color">{{$product_inventory->relationtocolor->color_name}}</span>
                            @endforeach
                        </div>
                        <div class="size-item mb-2 d-flex">
                            <input type="hidden" name="" value="" id="details_size_id">
                            <input type="hidden" name="" value="" class="details_sizes_count">
                            <span>Size:</span>
                            <div class="details_sizes_data d-flex">
                                <span>Click Color First</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="product-stock mb-20 mt-10">
                        <h5>Availability:
                        <span class="details_available_qty">{{($sum_quantity_inventories != 0) ? $sum_quantity_inventories." in stock" : "Stock out"}}</span>
                        </h5>
                    </div>
                    <div class="cart-option mb-15">
                        @if ($sum_quantity_inventories != 0)
                        <div class="product-quantity mr-20">
                            <div class="cart-plus-minus p-relative">
                                <div class="dec qtybutton" onclick="decrementValue()">-</div>
                                <input type="text" name="quantity" value="1" maxlength="1" max="5" size="1" id="cart_qty" />
                                <div class="inc qtybutton" onclick="incrementValue()">+</div>
                            </div>
                        </div>
                        <button class="btn btn-success mx-3" id="buy_now_btn">Buy Now</button>
                        <button class="cart-btn" id="add_to_cart_btn">Add to Cart</button>
                        @else
                        <button class="cart-btn" id="add_to_wishlist_btn">Add to wishlist</button>
                        @endif
                    </div>
                    <div class="details-meta d-flex">
                        <div class="d-meta-left">
                            @if ($sum_quantity_inventories != 0)
                            <div class="dm-item mr-20">
                                <button id="add_to_wishlist_btn"><i class="fal fa-heart"></i> Add to wishlist</button>
                            </div>
                            @endif
                        </div>
                        <div class="d-meta-left">
                            <div class="dm-item">
                                <i class="fal fa-share-alt"></i> Share link
                                <ul class="d-flex ">
                                    <li class="m-1"><a target="_blank" href="https://www.facebook.com/sharer.php?u={{ url()->current() }}" title="facebook"><span class="fab fa-facebook-square"></span></a></li>
                                    <li class="m-1"><a target="_blank" href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{$product->product_name}}"  title="twitter"><span class="fab fa-twitter"></span></a></li>
                                    <li class="m-1"><a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}"  title="linkedin"><span class="fab fa-linkedin"></span></a></li>
                                    <li class="m-1"><a target="_blank" href="https://pinterest.com/pin/create/button/?url={{ url()->current() }}&media={{$product->product_thumbnail_photo}}&description={{$product->product_name}}"  title="pinterest"><span class="fab fa-pinterest"></span></a></li>
                                    <li class="m-1"><a target="_blank" href="whatsapp://send?text={{ url()->current() }}"  title="whatsapp"><span class="fab fa-whatsapp"></span></a></li>
                                    <li class="m-1"><a target="_blank" href="https://telegram.me/share/url?url={{ url()->current() }}&text={{$product->product_name}}"  title="telegram"><span class="fab fa-telegram"></span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="product-tag-area mt-15">
                        <div class="product_info">
                            <span class="sku_wrapper">
                                <span class="title">SKU:</span>
                                <span class="sku">{{$product->sku}}</span>
                            </span>
                            <span class="posted_in">
                                <span class="title">Categories:</span>
                                <a href="{{ route('category.wise.product', $product->relationtocategory->category_slug) }}">{{$product->relationtocategory->category_name}}</a>
                            </span>
                            <span class="posted_in">
                                <span class="title">Subcategories:</span>
                                <a href="{{ route('subcategory.wise.product', $product->relationtosubcategory->subcategory_slug) }}">{{$product->relationtosubcategory->subcategory_name}}</a>
                            </span>
                            <span class="posted_in">
                                <span class="title">Childcategories:</span>
                                <a href="{{ route('childcategory.wise.product', $product->relationtochildcategory->childcategory_slug) }}">{{$product->relationtochildcategory->childcategory_name}}</a>
                            </span>
                            <span class="tagged_as">
                                <span class="title">Brand:</span>
                                <a href="{{ route('brand.wise.product', $product->relationtobrand->brand_slug) }}">{{$product->relationtobrand->brand_name}}</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- product-details-end -->

<!-- product-details-des-start -->
<div class="product-details-des mt-40 mb-60">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="product__details-des-tab">
                    <ul class="nav nav-tabs" id="productDesTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="des-tab" data-bs-toggle="tab" data-bs-target="#des"
                                type="button" role="tab" aria-controls="des" aria-selected="true">Description </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="aditional-tab" data-bs-toggle="tab" data-bs-target="#aditional"
                                type="button" role="tab" aria-controls="aditional" aria-selected="false">Additional
                                information</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review"
                                type="button" role="tab" aria-controls="review" aria-selected="false">Reviews ({{ $product_reviews->count() }})
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content" id="prodductDesTaContent">
            <div class="tab-pane fade active show" id="des" role="tabpanel" aria-labelledby="des-tab">
                <div class="product__details-des-wrapper">
                    <p class="des-text mb-35">
                        {!! $product->long_description !!}
                    </p>
                </div>
            </div>
            <div class="tab-pane fade" id="aditional" role="tabpanel" aria-labelledby="aditional-tab">
                <div class="product__desc-info">
                    <ul>
                        <li>
                            <h6>Weight</h6>
                            <span>{{$product->weight}}</span>
                        </li>
                        <li>
                            <h6>Dimensions</h6>
                            <span>{{$product->dimensions}}</span>
                        </li>
                        <li>
                            <h6>Materials</h6>
                            <span>{{$product->materials}}</span>
                        </li>
                        <li>
                            <h6>Color</h6>
                            @foreach ($product_inventories as $product_inventory)
                            <span class="badge">" {{$product_inventory->relationtocolor->color_name}} "</span>
                            @endforeach
                        </li>
                        <li>
                            <h6>Size</h6>
                            @foreach (App\Models\Product_inventory::where('product_id', $product->id)->select('size_id')->groupBy('size_id')->get() as $product_inventory)
                            <span class="badge">" {{$product_inventory->relationtosize->size_name}} "</span>
                            @endforeach
                        </li>
                        <li>
                            <h6>Other Info</h6>
                            <span>{{$product->other_info}}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                <div class="product__details-review">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="review-rate">
                                <h5>{{ $product_reviews->count() }}</h5>
                                <div class="review-star">
                                    @if ($product_reviews->average('rating'))
                                        @for ($star = 0; $star < round($product_reviews->average('rating')); $star++)
                                        <i class="fas fa-star"></i>
                                        @endfor
                                        @for ($star = 0; $star < 5-round($product_reviews->average('rating')); $star++)
                                        <i class="fal fa-star"></i>
                                        @endfor
                                    @else
                                        <i class="fal fa-star"></i>
                                        <i class="fal fa-star"></i>
                                        <i class="fal fa-star"></i>
                                        <i class="fal fa-star"></i>
                                        <i class="fal fa-star"></i>
                                    @endif
                                </div>
                                <span class="review-count">{{ $product_reviews->count() }} Review</span>
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <div class="review-des-infod">
                                <h6>{{ $product_reviews->count() }} review for "<span>{{$product->product_name}}</span>"</h6>
                                @foreach ($product_reviews as $review)
                                <div class="review-details-des">
                                    <div class="author-image mr-15">
                                        <a href="#"><img src="{{asset('frontend')}}/img/author/author-sm-1.jpeg" alt=""></a>
                                    </div>
                                    <div class="review-details-content">
                                        <div class="str-info">
                                            <div class="review-star mr-15">
                                                @for ($star = 0; $star < $review->rating; $star++)
                                                <i class="fas fa-star"></i>
                                                @endfor
                                                @for ($star = 0; $star < 5-$review->rating; $star++)
                                                <i class="fal fa-star"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="name-date mb-30">
                                            <h6> {{ $review->relationtouser->name }} – <span> {{$review->created_at->format('d-M-Y')}}</span></h6>
                                        </div>
                                        <p>{{ $review->review }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- product-details-des-end -->

<!-- related__products__area-start -->
<section class="recomand-product-area my-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section__head d-flex justify-content-between mb-10">
                    <div class="section__title">
                        <h5 class="st-titile">Related Products - ({{ $related_products->count() }})</h5>
                    </div>
                    <div class="button-wrap">
                        <a href="{{route('all.product')}}">See All Product <i class="fal fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="product-bs-slider">
                <div class="product-slider-2 swiper-container">
                    <div class="swiper-wrapper">
                        @forelse ($related_products as $product)
                        @include('frontend.part.product')
                        @empty
                        <div class="alert alert-danger">
                            <strong>Related Products Not Found</strong>
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
<!-- related__products__area-end -->
@endsection

@section('custom_script')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
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

        // Get Size
        $(document).on('click', '.details_select_color', function(e){
            e.preventDefault();
            var color_id = $(this).attr('id');
            var product_id = $('#details_product_id').val();
            $('#details_color_id').val(color_id);
            $('#details_size_id').val("");
            // ajax start
            $.ajax({
                type: 'POST',
                url: "{{route('get.sizes')}}",
                data: {
                    color_id: color_id,
                    product_id: product_id
                },

                success: function (data) {
                    $('.details_sizes_data').html(data.send_sizes);
                    $('.details_available_qty').html(data.send_qty);
                    $('.details_sizes_count').val(data.sizes_count);
                }
            })
            // ajax end
        });

        // Get QTY
        $(document).on('click', '.details_select_size', function(e){
            e.preventDefault();
            var size_id = $(this).attr('id');
            $('#details_size_id').val('');
            $('#details_size_id').val(size_id);
            var color_id = $('#details_color_id').val();
            var product_id = $('#details_product_id').val();
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
                    $('.details_available_qty').html(data.send_qty);
                }
            })
            // ajax end
        })

        var color_count = "{{ $product_inventories->count() }}"
        if(color_count == 1){
            $('.details_select_color').trigger('click');
        }

        // buy_now_btn
        $(document).on('click', '#buy_now_btn', function(e){
            e.preventDefault();
            var size_count = $('.details_sizes_count').val();
            if(size_count == 1){
                $('.details_select_size').trigger('click');
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
                    var available_qty = parseInt($('.details_available_qty').html());
                    var cart_qty = parseInt($('#cart_qty').val());
                    if (cart_qty > available_qty) {
                        Swal.fire(
                            'Stock not available this qty!',
                            'Please select available qty.',
                            'warning'
                        )
                    } else {
                        var color_id = $('#details_color_id').val();
                        var size_id = $('#details_size_id').val();
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
                                    var product_id = $('#details_product_id').val();
                                    var product_current_price = $('#product_discounted_price').val();
                                    var size_id = $('#details_size_id').val();
                                    var color_id = $('#details_color_id').val();
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
                                                position: 'canter',
                                                showConfirmButton: false,
                                                timer: 3000,
                                                timerProgressBar: true,
                                                didOpen: (toast) => {
                                                    toast.addEventListener('mouseenter', Swal
                                                        .stopTimer)
                                                    toast.addEventListener('mouseleave', Swal
                                                        .resumeTimer)
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

        // add_to_cart_btn
        $(document).on('click', '#add_to_cart_btn', function(e){
            e.preventDefault();
            var size_count = $('.details_sizes_count').val();
            if(size_count == 1){
                $('.details_select_size').trigger('click');
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
                    var available_qty = parseInt($('.details_available_qty').html());
                    var cart_qty = parseInt($('#cart_qty').val());
                    if (cart_qty > available_qty) {
                        Swal.fire(
                            'Stock not available this qty!',
                            'Please select available qty.',
                            'warning'
                        )
                    } else {
                        var color_id = $('#details_color_id').val();
                        var size_id = $('#details_size_id').val();
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
                                    var product_id = $('#details_product_id').val();
                                    var product_current_price = $('#product_discounted_price').val();
                                    var size_id = $('#details_size_id').val();
                                    var color_id = $('#details_color_id').val();
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
                                                $('#header_cart_count').html(data.cart_qty_status +
                                                    parseInt($('#header_cart_count').html()));
                                                    const Toast = Swal.mixin({
                                                    toast: true,
                                                    position: 'canter',
                                                    showConfirmButton: false,
                                                    timer: 3000,
                                                    timerProgressBar: true,
                                                    didOpen: (toast) => {
                                                        toast.addEventListener('mouseenter', Swal
                                                            .stopTimer)
                                                        toast.addEventListener('mouseleave', Swal
                                                            .resumeTimer)
                                                    }
                                                })

                                                Toast.fire({
                                                    icon: 'success',
                                                    title: 'Product Added successfully in Cart'
                                                })
                                                fetchHeaderCart();
                                            } else {
                                                $('#header_cart_count').html(data.cart_qty_status +
                                                    parseInt($('#header_cart_count').html()));
                                                const Toast = Swal.mixin({
                                                    toast: true,
                                                    position: 'canter',
                                                    showConfirmButton: false,
                                                    timer: 3000,
                                                    timerProgressBar: true,
                                                    didOpen: (toast) => {
                                                        toast.addEventListener('mouseenter', Swal
                                                            .stopTimer)
                                                        toast.addEventListener('mouseleave', Swal
                                                            .resumeTimer)
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

        // add_to_wishlist_btn
        $(document).on('click', '#add_to_wishlist_btn', function(e){
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
                    var product_id = $('#details_product_id').val();
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
                                $('#header_wishlist_num').html(data.wishlist_qty_status +
                                    parseInt($('#header_wishlist_num').html()));
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'canter',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal
                                            .stopTimer)
                                        toast.addEventListener('mouseleave', Swal
                                            .resumeTimer)
                                    }
                                })

                                Toast.fire({
                                    icon: 'success',
                                    title: 'Product Added successfully in Wishlist'
                                })
                            } else {
                                $('#header_wishlist_num').html(data.wishlist_qty_status +
                                    parseInt($('#header_wishlist_num').html()));
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'canter',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal
                                            .stopTimer)
                                        toast.addEventListener('mouseleave', Swal
                                            .resumeTimer)
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
    });

</script>
@endsection
