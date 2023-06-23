@php
$default_setting = App\Models\Default_setting::first();
@endphp
@extends('admin.layouts.auth_master')

@section('title_bar')
Login
@endsection

@section('body_content')
<div class="row clearfix">
    {{-- <div class="col-12">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="javascript:void(0);">
                <img src="{{asset('uploads/default_photo')}}/{{$default_setting->logo_photo}}" class="d-inline-block align-top mr-2" alt="">
            </a>
        </nav>
    </div> --}}
    <div class="col-lg-6">
        <div class="auth_detail">
            <h2 class="text-monospace">
                Everything<br> you need for
                <div id="carouselExampleControls" class="carousel vert slide" data-ride="carousel" data-interval="1500">
                    <div class="carousel-inner">
                        <div class="carousel-item active">your Admin</div>
                        <div class="carousel-item">your Project</div>
                        <div class="carousel-item">your Dashboard</div>
                        <div class="carousel-item">your Application</div>
                        <div class="carousel-item">your Client</div>
                    </div>
                </div>
            </h2>
            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
            <ul class="social-links list-unstyled">
                <li>
                    <a class="btn btn-default" target="_blank" href="{{$default_setting->facebook_link}}" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="fa fa-facebook"></i></a>
                </li>
                <li>
                    <a class="btn btn-default" target="_blank" href="{{$default_setting->twitter_link}}" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="fa fa-twitter"></i></a>
                </li>
                <li>
                    <a class="btn btn-default" target="_blank" href="{{$default_setting->instagram_link}}" data-toggle="tooltip" data-placement="top" title="Instagram"><i class="fa fa-instagram"></i></a>
                </li>
                <li>
                    <a class="btn btn-default" target="_blank" href="{{$default_setting->linkedin_link}}" data-toggle="tooltip" data-placement="top" title="Linkedin"><i class="fa fa-linkedin"></i></a>
                </li>
                <li>
                    <a class="btn btn-default" target="_blank" href="{{$default_setting->youtube_link}}" data-toggle="tooltip" data-placement="top" title="Youtube"><i class="fa fa-youtube"></i></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="header">
                <p class="lead">Login to your account</p>
            </div>
            <div class="body">

                @if (session('status'))
                <div class="alert alert-info" role="alert">
                    <strong>{{ session('status') }}</strong>
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    <strong>{{ session('error') }}</strong>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}" class="form-auth-small">
                    @csrf
                    <div class="form-group">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group clearfix">
                        <label class="fancy-checkbox element-left">
                            <input type="checkbox" class="form-check-input" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="form-check-label mb-0 ms-2 text-dark">Remember me</span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                    <div class="bottom">
                        <a class="helper-text m-b-10" href="{{ route('admin.password.request') }}">
                            <i class="fa fa-lock"></i> Forgot password?
                        </a>
                    </div>
                </form>

                <div class="demo mt-2">
                    <h5 class="text-center">Demo User Details</h5>
                    <div class="table-responsive">
                        <table class="table table-primary">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>superadmin@email.com</td>
                                    <td>12345678</td>
                                    <td>Super Admin</td>
                                </tr>
                                <tr>
                                    <td>admin@email.com</td>
                                    <td>12345678</td>
                                    <td>Admin</td>
                                </tr>
                                <tr>
                                    <td>dhakawarehouse@email.com</td>
                                    <td>12345678</td>
                                    <td>Manager</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
