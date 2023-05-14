@extends('frontend.layouts.frontend_master')

@section('title_bar')
Review
@endsection

@section('body_content')

<!-- page-banner-area-start -->
<div class="page-banner-area page-banner-height-2" data-background="{{asset('frontend')}}/img/banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-banner-content text-center">
                    <h4 class="breadcrumb-title">Review</h4>
                    <div class="breadcrumb-two">
                        <nav>
                            <nav class="breadcrumb-trail breadcrumbs">
                                <ul class="breadcrumb-menu">
                                    <li class="breadcrumb-trail">
                                        <a href="{{route('index')}}"><span>Home</span></a>
                                    </li>
                                    <li class="trail-item">
                                        <span>Review</span>
                                    </li>
                                </ul>
                            </nav>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- page-banner-area-end -->

<!-- account-area-start -->
<div class="account-area mt-70 mb-70">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                @foreach ($order_details as $order_detail)
                <div class="card mb-3">
                    <div class="card-header">
                        <h4 class="card-title">Review</h4>
                        <p class="card-text m-0">Please give true review in this product. </p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 d-flex align-items-center">
                                <img width="120" height="120" src="{{asset('uploads/product_thumbnail_photo')}}/{{$order_detail->relationtoproduct->product_thumbnail_photo}}" alt="product">
                                <div class="text">
                                    <p class="card-text m-0">Product Name: <a href="{{route('product.details', $order_detail->relationtoproduct->product_slug)}}">{{$order_detail->relationtoproduct->product_name}}</a></p>
                                    <p class="card-text m-0">Color: {{$order_detail->relationtocolor->color_name}}</p>
                                    <p class="card-text m-0">Size: {{$order_detail->relationtosize->size_name}}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                @php
                                    $review = App\Models\Review::where('order_detail_id', $order_detail->id)->first();
                                @endphp
                                @if ($review)
                                <div class="alert alert-dark">
                                    <div class="rating-product">
                                        <strong>Review: {{ $review->review }}</strong><br>
                                        <strong>Rating: {{ $review->rating }}</strong><br>
                                        <strong>Review Date: {{ $review->created_at->format('D d-M,Y h:m:s A') }}</strong>
                                    </div>
                                </div>
                                @else
                                <form action="{{route('order.review.post', $order_detail->id)}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label>Overall ratings</label><br>
                                            <div class="rate">
                                                <input type="radio" id="star5" name="rating" value="5" />
                                                <label for="star5" title="text">5 stars</label>
                                                <input type="radio" id="star4" name="rating" value="4" />
                                                <label for="star4" title="text">4 stars</label>
                                                <input type="radio" id="star3" name="rating" value="3" />
                                                <label for="star3" title="text">3 stars</label>
                                                <input type="radio" id="star2" name="rating" value="2" />
                                                <label for="star2" title="text">2 stars</label>
                                                <input type="radio" id="star1" name="rating" value="1" />
                                                <label for="star1" title="text">1 star</label>
                                            </div>
                                            @error('review')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="comment-input-box">
                                                <label>Your review</label>
                                                <textarea name="review" class="form-control @error('review') is-invalid @enderror" placeholder="Write our review here">{{ old('email') }}</textarea>
                                                @error('review')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="comment-submit mt-3">
                                            <button type="submit" class="cart-btn">Give Review</button>
                                        </div>
                                    </div>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- account-area-end -->
@endsection

@section('custom_script')
<script>

</script>
@endsection
