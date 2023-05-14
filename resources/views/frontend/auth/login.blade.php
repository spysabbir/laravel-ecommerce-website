@extends('frontend.layouts.frontend_master')

@section('title_bar')
Login
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
                                        <span>Login</span>
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
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Login</h4>
                        <p class="card-text">Login</p>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-info" role="alert">
                            <strong>{{ session('status') }}</strong>
                        </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email">Email Address <span>*</span></label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" placeholder="Email Address">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password">Password <span>*</span></label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    placeholder="Password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="login-action mb-10 fix">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                    <label class="form-check-label" for="remember_me">
                                        Remember me
                                    </label>
                                </div>
                                <span class="forgot-login f-right">
                                    @if (Route::has('password.request'))
                                    <a class="text-warning" href="{{ route('password.request') }}">Lost your password?</a>
                                    @endif
                                </span>
                            </div>
                            <button type="submit" class="tp-in-btn w-100">log in</button>
                            <div class="text-center mt-5">
                                <a class="tp-in-btn bg-info" href="{{route('register')}}">Register...</a>
                            </div>
                        </form>
                    </div>
                    <div class="text-center my-3">
                        @if (App\Models\Social_login_setting::first()->google_auth_status == "Yes" )
                        <a class="btn btn-danger" href="{{route('google.login')}}">Google</a>
                        @endif
                        @if (App\Models\Social_login_setting::first()->facebook_auth_status == "Yes" )
                        <a class="btn btn-primary" href="{{route('facebook.login')}}">Facebook</a>
                        @endif
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
