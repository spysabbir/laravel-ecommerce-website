@forelse ($top_view_products as $product)
@php
    $flashsale = App\Models\Flashsale::find($product->flashsale_id)
@endphp
<li>
    <div class="feed-number">
        <a href="{{route('product.details', $product->product_slug)}}"><img src="{{asset('uploads/product_thumbnail_photo')}}/{{$product->product_thumbnail_photo}}" alt=""></a>
    </div>
    <div class="feed-content">
        <h6><a href="{{route('product.details', $product->product_slug)}}">{{$product->product_name}}</a></h6>
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
</li>
@empty
<div class="alert alert-warning">
    <strong>Top view Product Item Not Found........</strong>
</div>
@endforelse
