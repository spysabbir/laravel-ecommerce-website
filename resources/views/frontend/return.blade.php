@extends('frontend.layouts.frontend_master')

@section('title_bar')
Return
@endsection

@section('body_content')

<!-- page-banner-area-start -->
<div class="page-banner-area page-banner-height-2" data-background="{{asset('frontend')}}/img/banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-banner-content text-center">
                    <h4 class="breadcrumb-title">Return</h4>
                    <div class="breadcrumb-two">
                        <nav>
                            <nav class="breadcrumb-trail breadcrumbs">
                                <ul class="breadcrumb-menu">
                                    <li class="breadcrumb-trail">
                                        <a href="{{route('index')}}"><span>Home</span></a>
                                    </li>
                                    <li class="trail-item">
                                        <span>Return</span>
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
                        <h4 class="card-title">Return</h4>
                        <p class="card-text m-0">Return request confirm will next 3 working day.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 d-flex align-items-center">
                                <img width="120" height="120" src="{{asset('uploads/product_thumbnail_photo')}}/{{$order_detail->relationtoproduct->product_thumbnail_photo}}" alt="product">
                                <div class="text">
                                    <p class="card-text m-0">Product Name: <a href="{{route('product.details', $order_detail->relationtoproduct->product_slug)}}">{{$order_detail->relationtoproduct->product_name}}</a></p>
                                    <p class="card-text m-0">Color: {{$order_detail->relationtocolor->color_name}}</p>
                                    <p class="card-text m-0">Size: {{$order_detail->relationtosize->size_name}}</p>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                @php
                                    $return_status = App\Models\Order_return::where('order_detail_id', $order_detail->id)->first();
                                @endphp
                                @if ($return_status)
                                <strong> Return Status: </strong> {{ $return_status->return_status }}
                                <br>
                                <strong> Return Request Date: </strong> {{ $return_status->created_at->format('D d-M,Y h:m:s A') }}
                                <br>
                                <strong> Return Confirm Date: </strong> {{ ($return_status->updated_at == NULL) ? "Pending" : date('d-M-Y h:m:s A', strtotime($return_status->updated_at)) }}
                                @else
                                <form action="{{route('order.return.post', $order_detail->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h4>Return reason</h4>
                                            <div class="mt-3">
                                                <label>Return Reason Details</label>
                                                <textarea name="return_reason_details" class="form-control @error('return_reason_details') is-invalid @enderror" placeholder="Write our return reason details here">{{ old('return_reason_details') }}</textarea>
                                                @error('return_reason_details')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mt-3">
                                                <label>Return Reason Photo</label>
                                                <input type="file" name="return_reason_photo" class="form-control @error('return_reason_photo') is-invalid @enderror">
                                                @error('return_reason_photo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h4>Refund Details</h4>
                                            <div class="mt-3">
                                                <label>Account Holder Name</label>
                                                <input type="text" name="account_holder_name" class="form-control @error('account_holder_name') is-invalid @enderror" placeholder="Write our account holder name" value="{{ old('account_holder_name') }}">
                                                @error('account_holder_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mt-3">
                                                <label>Account Type</label>
                                                <input type="text" name="account_type" class="form-control @error('account_type') is-invalid @enderror" placeholder="Write our account type" value="{{ old('account_type') }}">
                                                @error('account_type')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mt-3">
                                                <label>Account Number</label>
                                                <input type="text" name="account_number" class="form-control @error('account_number') is-invalid @enderror" placeholder="Write our account number" value="{{ old('account_number') }}">
                                                @error('account_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="comment-submit">
                                            <button type="submit" class="cart-btn">Return Request</button>
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
