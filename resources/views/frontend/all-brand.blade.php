@extends('frontend.layouts.frontend_master')

@section('title_bar')
All Brand
@endsection

@section('body_content')
<!-- page-banner-area-start -->
<div class="page-banner-area page-banner-height-2" data-background="{{asset('frontend')}}/img/banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-banner-content text-center">
                    <h4 class="breadcrumb-title">All Brand</h4>
                    <div class="breadcrumb-two">
                        <nav>
                            <nav class="breadcrumb-trail breadcrumbs">
                                <ul class="breadcrumb-menu">
                                    <li class="breadcrumb-trail">
                                        <a href="{{route('index')}}"><span>Home</span></a>
                                    </li>
                                    <li class="trail-item">
                                        <span>All Brand</span>
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

<!-- brand-area-start -->
<section class="brand-area brand-area-d pt-40">
    <div class="container">
        <div class="row pt-50 pb-45">
            @forelse ($brands as $brand)
            <div class="col-lg-2 my-4">
                <div class="brand-item w-img">
                    <a href="{{ route('brand.wise.product', $brand->brand_slug) }}"><img class="w-100 imf-fluid" src="{{asset('uploads/brand_photo')}}/{{$brand->brand_photo}}" alt="{{$brand->brand_name}}"></a>
                </div>
            </div>
            @empty
            <div class="col-xl-12">
                <div class="alert alert-warning text-center" role="alert">
                    <strong>Brand Item Not Found!</strong>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>
<!-- brand-area-end -->

@endsection

@section('custom_script')
<script>

</script>
@endsection
