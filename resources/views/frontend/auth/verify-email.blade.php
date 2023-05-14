@extends('frontend.layouts.frontend_master')

@section('title_bar')
Verify Email
@endsection

@section('body_content')

<!-- page-banner-area-start -->
<div class="page-banner-area page-banner-height-2" data-background="{{asset('frontend')}}/img/banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-banner-content text-center">
                    <h4 class="breadcrumb-title">My account</h4>
                    <div class="breadcrumb-two">
                        <nav>
                            <nav class="breadcrumb-trail breadcrumbs">
                                <ul class="breadcrumb-menu">
                                    <li class="breadcrumb-trail">
                                        <a href="{{route('index')}}"><span>Home</span></a>
                                    </li>
                                    <li class="trail-item">
                                        <span>Verify Email</span>
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
                <div class="col-lg-6">
                    <div class="about-image w-img">
                        <img src="{{asset('frontend')}}/img/about-b.png" alt="">
                    </div>
                </div>
                <div class="col-lg-6 ">
                    <div class="card ">
                        <div class="card-header">
                            <h4 class="card-title">Verify Email</h4>
                            <p class="card-text">Verify Email</p>
                        </div>
                        <div class="card-body">

                            @if (session('status' == 'verification-link-sent'))
                            <div class="alert alert-info" role="alert">
                                <strong>A new verification link has been sent to the email address you provided during registration.</strong>
                            </div>
                            @endif
                            <span>Before proceeding, please check your email for a verification link.</span>
                            <span>If you did not receive the email</span>
                            <form class="d-inline mb-5" method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">click here to request another</button>.
                            </form>

                            <form class="mt-5" method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit" class="btn btn-primary">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
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
