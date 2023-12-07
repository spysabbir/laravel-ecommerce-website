@extends('frontend.layouts.frontend_master')

@section('title_bar')
All Flashsale
@endsection

@section('body_content')
<!-- page-banner-area-start -->
<div class="page-banner-area page-banner-height-2" data-background="{{asset('frontend')}}/img/banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-banner-content text-center">
                    <h4 class="breadcrumb-title">All Flashsale</h4>
                    <div class="breadcrumb-two">
                        <nav>
                            <nav class="breadcrumb-trail breadcrumbs">
                                <ul class="breadcrumb-menu">
                                    <li class="breadcrumb-trail">
                                        <a href="{{route('index')}}"><span>Home</span></a>
                                    </li>
                                    <li class="trail-item">
                                        <span>All Flashsale</span>
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

<!-- flashsale-area-start -->
<section class="brand-area brand-area-d pt-40">
    <div class="container">
        <div class="row pt-50 pb-45">
            @forelse ($flashsales as $flashsale)
            <div class="col-xl-12 mb-3">
                <div class="shop-banner mb-30">
                    <div class="banner-image">
                        <a href="{{ route('flashsale.product', $flashsale->flashsale_offer_slug) }}"><img class="banner-l" width="479" height="185" src="{{ asset('uploads/flashsale_offer_banner_photo') }}/{{ $flashsale->flashsale_offer_banner_photo }}" alt=""></a>
                        <div class="banner-content bg-dark text-center py-2 px-5">
                            <p class="m-0 p-0">Hurry Up!</p>
                            <p class="m-0 p-0"><strong>Offer Name : </strong>{{ $flashsale->flashsale_offer_name }} </p>
                            <p class="m-0 p-0"><strong>Offer Amount: </strong>{{ $flashsale->flashsale_offer_amount }} {{ ($flashsale->flashsale_offer_type == 'Percentage') ? '%' : '৳' }}</p>
                            <p class="m-0 p-0"><strong>Minimum Product Price: </strong>{{ $flashsale->flashsale_minimum_product_price }} ৳</p>
                            <p class="m-0 p-0"><strong>Start End: </strong>{{ date('d-M-Y H:i:s A', strtotime($flashsale->flashsale_offer_start_date)) }}</p>
                            <p class="m-0 p-0"><strong>Offer End: </strong>{{ date('d-M-Y H:i:s A', strtotime($flashsale->flashsale_offer_end_date)) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-xl-12">
                <div class="alert alert-warning text-center" role="alert">
                    <strong>Flashsale Item Not Found!</strong>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>
<!-- flashsale-area-end -->

@endsection

@section('custom_script')
<script>

</script>
@endsection
