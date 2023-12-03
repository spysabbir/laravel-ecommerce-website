<!-- Quick View Modal Start -->
<div class="modal-content">
    <div class="product__modal-wrapper p-relative">
        <div class="product__modal-close p-absolute">
            <button data-bs-dismiss="modal"><i class="fal fa-times"></i></button>
        </div>
        <div class="product__modal-inner" >
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="product__modal-box">
                        <input type="hidden" value="{{$product->id}}" id="model_product_id">
                        <div class="tab-content" id="modalTabContent">
                            <div class="tab-pane fade show active" id="nav0" role="tabpanel"
                                aria-labelledby="nav0-tab">
                                <div class="product__modal-img w-img">
                                    <img src="{{asset('uploads/product_thumbnail_photo')}}/{{$product->product_thumbnail_photo}}" alt="">
                                </div>
                            </div>
                            @foreach (App\Models\Product_featured_photo::where('product_id', $product->id)->get() as $product_featured_photo)
                            <div class="tab-pane fade" id="nav{{$product_featured_photo->id}}" role="tabpanel" aria-labelledby="nav{{$product_featured_photo->id}}-tab">
                                <div class="product__modal-img w-img">
                                    <img src="{{asset('uploads/product_featured_photos')}}/{{$product_featured_photo->product_featured_photos}}" alt="">
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <ul class="nav nav-tabs" id="modalTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="nav0-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav0" type="button" role="tab" aria-controls="nav0"
                                    aria-selected="true">
                                    <img width="65" height="65" src="{{asset('uploads/product_thumbnail_photo')}}/{{$product->product_thumbnail_photo}}" alt="">
                                </button>
                            </li>
                            @foreach (App\Models\Product_featured_photo::where('product_id', $product->id)->get() as $product_featured_photo)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="nav{{$product_featured_photo->id}}-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav{{$product_featured_photo->id}}" type="button" role="tab" aria-controls="nav{{$product_featured_photo->id}}"
                                    aria-selected="false">
                                    <img width="65" height="65" src="{{asset('uploads/product_featured_photos')}}/{{$product_featured_photo->product_featured_photos}}" alt="">
                                </button>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="product__modal-content">
                        <h4><a href="{{route('product.details', $product->product_slug)}}">{{$product->product_name}}</a></h4>
                        <div class="product__review d-sm-flex">
                            <div class="rating rating__shop mb-10 mr-30">
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
                            <div class="product__add-review mb-15">
                                <span>{{ $product_reviews->count() }} review</span>
                            </div>
                        </div>
                        <div class="product__price">
                            @php
                                $flashsale = App\Models\Flashsale::find($product->flashsale_id)
                            @endphp
                            <span class="text-danger"><del>৳ {{$product->regular_price}}</del></span>
                            @if ($product->flashsale_status == "Yes")
                                @if ($flashsale->status == "Yes" && $flashsale->flashsale_offer_start_date < Carbon\Carbon::now() && $flashsale->flashsale_offer_end_date > Carbon\Carbon::now())
                                    @if($flashsale->flashsale_offer_type == 'Percentage')
                                        <span>৳ {{ $product_discounted_price = $product->regular_price - ($product->regular_price*($flashsale->flashsale_offer_amount/100)) }}</span>
                                    @else
                                        <span>৳ {{ $product_discounted_price = $product->regular_price - $flashsale->flashsale_offer_amount }}</span>
                                    @endif
                                @else
                                    <span>৳ {{$product_discounted_price = $product->discounted_price}}</span>
                                @endif
                            @else
                                <span>৳ {{$product_discounted_price = $product->discounted_price}}</span>
                            @endif
                            <input type="hidden" value="{{$product_discounted_price}}" id="product_discounted_price">
                        </div>
                        <div class="product__modal-des mt-20 mb-15">
                            {!! Str::words($product->short_description, 25, '...') !!}
                        </div>
                        <div class="inventory mb-20 mt-10">
                            @php
                                $product_inventories = App\Models\Product_inventory::where('product_id', $product->id)->select('color_id')->groupBy('color_id')->get();
                                $sum_quantity_inventories = App\Models\Product_inventory::where('product_id', $product->id)->sum('quantity')
                            @endphp
                            @if ($sum_quantity_inventories != 0)
                            <div class="color-item mb-2 d-flex">
                                <input type="hidden" name="" value="" id="model_color_id">
                                <input type="hidden" name="" value="{{ $product_inventories->count() }}" class="model_color_count">
                                <span>Color:</span>
                                @foreach ($product_inventories as $product_inventory)
                                <span id="{{$product_inventory->color_id}}" style="background-color: {{$product_inventory->relationtocolor->color_code}}" class="border model_select_color">{{$product_inventory->relationtocolor->color_name}}</span>
                                @endforeach
                            </div>
                            <div class="size-item mb-2 d-flex">
                                <input type="hidden" name="" value="" id="model_size_id">
                                <input type="hidden" name="" value="" id="model_sizes_count">
                                <span>Size:</span>
                                <div class="model_sizes_data d-flex">
                                    <span>Click Color First</span>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="product__stock mb-20"></div>
                            <span class="mr-10">Availability :</span>
                            <span class="model_available_qty">{{($sum_quantity_inventories != 0) ? $sum_quantity_inventories." in stock" : "Stock out"}}</span>
                        </div>
                        @auth
                        <input type="hidden" id="login_status" value="yes">
                        @else
                        <input type="hidden" id="login_status" value="no">
                        @endauth
                        <div class="product__modal-form my-3">
                            <div class="pro-quan-area">
                                @if ($sum_quantity_inventories != 0)
                                <div class="product-quantity mr-20">
                                    <div class="cart-plus-minus p-relative">
                                        <div class="dec qtybutton" onclick="decrementValue()">-</div>
                                        <input type="text" name="quantity" value="1" maxlength="1" max="5" size="1" id="cart_qty" />
                                        <div class="inc qtybutton" onclick="incrementValue()">+</div>
                                    </div>
                                </div>
                                <div class="pro-cart-btn mt-3">
                                    <button class="btn btn-success mx-3 buyNowBtn" id="{{$product->id}}" type="submit">Buy Now</button>
                                    <button class="cart-btn addToCartBtn" id="{{$product->id}}" type="submit">Add to cart</button>
                                </div>
                                @else
                                    <button class="cart-btn addToWishlistBtn" id="{{$product->id}}">Add to wishlist</button>
                                @endif
                            </div>
                        </div>
                        <div class="product__stock mb-30">
                            <ul>
                                <li>
                                    <span class="sku mr-10">SKU:</span>
                                    <span>{{$product->sku}}</span>
                                </li>
                                <li>
                                    <a href="{{ route('category.wise.product', $product->relationtocategory->category_slug) }}">
                                        <span class="cat mr-10">Categories:</span>
                                        <span>{{$product->relationtocategory->category_name}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('subcategory.wise.product', $product->relationtosubcategory->subcategory_slug) }}">
                                        <span class="cat mr-10">Subcategories:</span>
                                        <span>{{$product->relationtosubcategory->subcategory_name}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('childcategory.wise.product', $product->relationtochildcategory->childcategory_slug) }}">
                                        <span class="cat mr-10">Childcategories:</span>
                                        <span>{{$product->relationtochildcategory->childcategory_name}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('brand.wise.product', $product->relationtobrand->brand_slug) }}">
                                        <span class="tag mr-10">Brand:</span>
                                        <span>{{$product->relationtobrand->brand_name}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
