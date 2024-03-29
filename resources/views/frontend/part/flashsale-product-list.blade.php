@forelse ($products as $product)
@php
    $flashsale = App\Models\Flashsale::find($flashsale->id)
@endphp
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="product__item product__item-d">
        <div class="product__thumb fix">
            <div class="product-image w-img">
                <a href="{{ route('flashsale.product.details', ['flashsaleSlug' => $flashsale->flashsale_offer_slug, 'productSlug' => $product->product_slug]) }}">
                    <img src="{{asset('uploads/product_thumbnail_photo')}}/{{$product->product_thumbnail_photo}}"
                        alt="product">
                </a>
            </div>
            @if (App\Models\Product_inventory::where('product_id', $product->id)->sum('quantity') == 0)
            <div class="product__offer">
                <span class="discount">Stock Out</span>
            </div>
            @else
                @if ($product->discounted_price != $product->regular_price)
                <div class="product__offer">
                    @if ($flashsale->flashsale_offer_type == 'Flat')
                        <span class="discount">
                            {{round(($flashsale->flashsale_offer_amount/$product->regular_price) * 100, 2)}}% OFF
                        </span>
                    @else
                        <span class="discount">{{$flashsale->flashsale_offer_amount}}% OFF</span>
                    @endif
                </div>
                @endif
            @endif
            <div class="product-action">
                <a href="#" class="icon-box icon-box-1 quickViewFlashsaleProductBtn" data-product-id="{{$product->id}}" data-flashsale-id="{{$flashsale->id}}" data-bs-toggle="modal"
                    data-bs-target="#quickViewFlashsaleProductModal">
                    <i class="fal fa-eye"></i>
                    <i class="fal fa-eye"></i>
                </a>
                <a href="#" class="icon-box icon-box-1 addToWishlistBtn" id="{{$product->id}}">
                    <i class="fal fa-heart"></i>
                    <i class="fal fa-heart"></i>
                </a>
            </div>
        </div>
        <div class="product__content-3 py-2">
            <h6><a href="{{ route('flashsale.product.details', ['flashsaleSlug' => $flashsale->flashsale_offer_slug, 'productSlug' => $product->product_slug]) }}">{{$product->product_name}}</a>
            </h6>
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
                @if($flashsale->flashsale_offer_type == 'Percentage')
                    ৳ {{ $product->regular_price - ($product->regular_price*($flashsale->flashsale_offer_amount/100)) }}
                @else
                    ৳ {{ $product->regular_price - $flashsale->flashsale_offer_amount }}
                @endif
            </div>
        </div>
        <div class="product__add-cart-s text-center">
            <button type="button"
                class="cart-btn d-flex mb-10 align-items-center justify-content-center w-100 quickViewFlashsaleProductBtn"
                data-product-id="{{$product->id}}" data-flashsale-id="{{$flashsale->id}}" data-bs-toggle="modal" data-bs-target="#quickViewFlashsaleProductModal">
                Add to Cart
            </button>
            <button type="button"
                class="wc-checkout d-flex align-items-center justify-content-center w-100 quickViewFlashsaleProductBtn"
                data-product-id="{{$product->id}}" data-flashsale-id="{{$flashsale->id}}" data-bs-toggle="modal" data-bs-target="#quickViewFlashsaleProductModal">
                Quick View
            </button>
        </div>
    </div>
</div>
@empty
<div class="cl-lg-12">
    <div class="alert alert-warning text-center">
        <strong>Product Not Found........</strong>
    </div>
</div>
@endforelse
