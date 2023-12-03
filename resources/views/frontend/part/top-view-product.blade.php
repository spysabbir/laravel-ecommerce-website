@forelse ($top_view_products as $product)
<li>
    <div class="feed-number">
        <a href="{{route('product.details', $product->product_slug)}}"><img src="{{asset('uploads/product_thumbnail_photo')}}/{{$product->product_thumbnail_photo}}" alt=""></a>
    </div>
    <div class="feed-content">
        <h6><a href="{{route('product.details', $product->product_slug)}}">{{$product->product_name}}</a></h6>
        <div class="price mb-10">
            <span class="text-danger"><del>৳ {{$product->regular_price}}</del></span>
            ৳ {{$product->discounted_price}}
        </div>
    </div>
</li>
@empty
<div class="alert alert-warning">
    <strong>Top view Product Item Not Found........</strong>
</div>
@endforelse
