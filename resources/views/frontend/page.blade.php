@extends('frontend.layouts.frontend_master')

@section('title_bar')
{{ $page->page_name }}
@endsection

@section('body_content')
<!-- page-banner-area-start -->
<div class="page-banner-area page-banner-height-2" data-background="{{asset('frontend')}}/img/banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-banner-content text-center">
                    <h4 class="breadcrumb-title">{{ $page->page_name }}</h4>
                    <div class="breadcrumb-two">
                        <nav>
                            <nav class="breadcrumb-trail breadcrumbs">
                                <ul class="breadcrumb-menu">
                                    <li class="breadcrumb-trail">
                                        <a href="{{route('index')}}"><span>Home</span></a>
                                    </li>
                                    <li class="trail-item">
                                        <span>{{ $page->page_name }}</span>
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

<!-- about-area-start -->
<div class="about-area pt-80 pb-80" data-background="{{asset('frontend')}}/img/about-bg.png">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-12">
                <div class="about-content">
                    <span>{{ $page->page_name }}</span>
                    <p>{!! $page->page_content !!}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- about-area-end -->
@endsection

@section('custom_script')
<script>

</script>
@endsection
