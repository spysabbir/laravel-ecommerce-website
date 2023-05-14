@php
$default_setting = App\Models\Default_setting::first();
@endphp
@extends('admin.layouts.auth_master')

@section('title_bar')
Reset Password
@endsection

@section('body_content')
<div class="row clearfix">
    <div class="col-12">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="javascript:void(0);">
                <img src="{{asset('uploads/default_photo')}}/{{$default_setting->logo_photo}}" class="d-inline-block align-top mr-2" alt="">
            </a>
        </nav>
    </div>
    <div class="col-lg-8">
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
    <div class="col-lg-4">
        <div class="card">
            <div class="header">
                <p class="lead">Recover my password</p>
            </div>
            <div class="body">
                <p>Please enter your email address below to receive instructions for resetting password.</p>
                <form method="POST" action="{{ route('admin.password.update') }}" class="form-auth-small">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <div class="form-group">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $request->email) }}" placeholder="Email" readonly>
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
                    <div class="form-group">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Confirm password">
                        @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
