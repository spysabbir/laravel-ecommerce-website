@php
    $flashsale = App\Models\Flashsale::where('id', $product->flashsale_id)->first()
@endphp
<div class="product__item swiper-slide">
    <div class="product__thumb fix">
        <div class="product-image w-img">
            <a href="{{route('product.details', $product->product_slug)}}">
                <img src="{{asset('uploads/product_thumbnail_photo')}}/{{$product->product_thumbnail_photo}}" alt="product">
            </a>
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

        @auth
        <input type="hidden" id="login_status" value="yes">
        @else
        <input type="hidden" id="login_status" value="no">
        @endauth

        <div class="product-action">
            <a href="#" class="icon-box icon-box-1 quickViewProductBtn" id="{{$product->id}}" data-bs-toggle="modal"
                data-bs-target="#quickViewProductModal">
                <i class="fal fa-eye"></i>
                <i class="fal fa-eye"></i>
            </a>
            <a href="#" class="icon-box icon-box-1 addToWishlistBtn" id="{{$product->id}}">
                <i class="fal fa-heart"></i>
                <i class="fal fa-heart"></i>
            </a>
        </div>
    </div>
    <div class="product__content">
        <h6><a href="{{route('product.details', $product->product_slug)}}">{{$product->product_name}}</a></h6>
        @php
            $product_reviews = App\Models\Review::where('product_id', $product->id)->get();
        @endphp
        <div class="rating mb-5">
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
            <span>({{ $product_reviews->count() }} review)</span>
        </div>

        <div class="price mb-10">
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
    <div class="product__add-cart text-center">
        <button type="button" class="cart-btn product-modal-sidebar-open-btn d-flex align-items-center justify-content-center w-100 quickViewProductBtn" id="{{$product->id}}" data-bs-toggle="modal"
            data-bs-target="#quickViewProductModal">
            Add to Cart
        </button>
    </div>
</div>
