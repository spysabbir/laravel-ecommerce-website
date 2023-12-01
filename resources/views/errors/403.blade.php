@php
    $default_setting = App\Models\Default_setting::first();
@endphp
@extends('errors::layout')

@section('title_bar')
403 - Forbidden
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
            <p>Please enter your email address below to receive instructions for resetting password.</p>
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
                <h3>
                    <span class="clearfix title">
                        <span class="number left">Error </span><span class="text">403 <br/>Forbidden!</span>
                    </span>
                </h3>
            </div>
            <div class="body">
                <p>You don't have permission to access / on this server.</p>
                <div class="margin-top-30">
                    <a href="javascript:history.go(-1)" class="btn btn-default btn-block"><i class="fa fa-arrow-left"></i> <span>Go Back</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
