@extends('frontend.layouts.frontend_master')

@section('title_bar')
About Us
@endsection

@section('body_content')

<!-- page-banner-area-start -->
<div class="page-banner-area page-banner-height-2" data-background="{{asset('frontend')}}/img/banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-banner-content text-center">
                    <h4 class="breadcrumb-title">About Us</h4>
                    <div class="breadcrumb-two">
                        <nav>
                            <nav class="breadcrumb-trail breadcrumbs">
                                <ul class="breadcrumb-menu">
                                    <li class="breadcrumb-trail">
                                        <a href="{{route('index')}}"><span>Home</span></a>
                                    </li>
                                    <li class="trail-item">
                                        <span>About Us</span>
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
            <div class="col-xl-6 col-lg-6">
                <div class="about-content">
                    <span>ABOUT OUR ONLINE STORE</span>
                    <h4>Hello,</h4>
                    <h5 class="banner-t mb-30">With {{ (date('Y')-2022) }}+ Years Of Experience</h5>
                    <p class="about-text">Over {{ (date('Y')-2022) }} years {{ env('APP_NAME') }} helping companies reach their <br> financial and
                        branding goals.</p>
                    <p>The perfect way to enjoy brewing tea on low hanging fruit to identify. Duis autem vel eum iriure
                        dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla
                        facilisis. For me, the most important part of improving at photography.</p>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="about-image w-img">
                    <img src="{{asset('frontend')}}/img/about-b.png" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- about-area-end -->

<!-- services-area-start -->
<div class="services-area pt-70 light-bg-s pb-50">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="abs-section-title text-center">
                    <span>HOW IT WORKS</span>
                    <h4>Complete Customer Ideas</h4>
                    <p>The perfect way to enjoy brewing tea on low hanging fruit to identify. Duis autem vel eum iriure
                        dolor in hendrerit <br> in vulputate velit esse molestie consequat, vel illum dolore eu feugiat
                        nulla facilisis.</p>
                </div>
            </div>
        </div>
        <div class="row mt-40">
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="services-item mb-30">
                    <div class="services-icon mb-25">
                        <i class="fal fa-share-square"></i>
                    </div>
                    <h6>Admin Verify Details</h6>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit accusantium doloremque laudantium totam rem
                        aperiam, eaqueipsa quae veritatis.</p>
                    <div class="s-count-number">
                        <span>01</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="services-item mb-30">
                    <div class="services-icon mb-25">
                        <i class="fal fa-file"></i>
                    </div>
                    <h6>Send The Solution</h6>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit accusantium doloremque laudantium totam rem
                        aperiam, eaqueipsa quae veritatis.</p>
                    <div class="s-count-number">
                        <span>02</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="services-item mb-30">
                    <div class="services-icon mb-25">
                        <i class="fal fa-thumbs-up"></i>
                    </div>
                    <h6>Complete Profile</h6>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit accusantium doloremque laudantium totam rem
                        aperiam, eaqueipsa quae veritatis.</p>
                    <div class="s-count-number">
                        <span>03</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- services-area-end -->

<!-- technolgy-index-start -->
<div class="technolgy-index mt-70 mb-10">
    <div class="container">
        <div class="row mb-15">
            <div class="col-xl-12">
                <div class="abs-section-title text-center">
                    <span>TECHNOLOGY INDEX</span>
                    <h4>Let’s Get Creative</h4>
                    <p>The perfect way to enjoy brewing tea on low hanging fruit to identify. Duis autem vel eum iriure
                        dolor in hendrerit <br> in vulputate velit esse molestie consequat, vel illum dolore eu feugiat
                        nulla facilisis.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="main-abs mb-30">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                            <div class="ab-counter-item mb-30">
                                <div class="ab-counter mb-20">
                                    <div class="counter-icon mr-10">
                                        <img src="{{asset('frontend')}}/img/c-icon-01.png" alt="">
                                    </div>
                                    <div class="counter_info">
                                        <span class="counter">{{ App\Models\User::all()->count() }}</span>
                                        <p>+</p>
                                    </div>
                                </div>
                                <h5>Active Customer</h5>
                                <p>Sed ut perspiciatis unde omnis iste natus sit accusantium doloremque laudantium
                                    totam.</p>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                            <div class="ab-counter-item mb-30">
                                <div class="ab-counter mb-20">
                                    <div class="counter-icon mr-10">
                                        <img src="{{asset('frontend')}}/img/c-icon-01.png" alt="">
                                    </div>
                                    <div class="counter_info">
                                        <span class="counter">{{ App\Models\Order_summery::all()->count() }}</span>
                                        <p>+</p>
                                    </div>
                                </div>
                                <h5>Order Complete</h5>
                                <p>Sed ut perspiciatis unde omnis iste natus sit accusantium doloremque laudantium
                                    totam.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="main-abs mb-30">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                            <div class="ab-counter-item mb-30">
                                <div class="ab-counter mb-20">
                                    <div class="counter-icon mr-10">
                                        <img src="{{asset('frontend')}}/img/c-icon-01.png" alt="">
                                    </div>
                                    <div class="counter_info">
                                        <span class="counter">{{ App\Models\Product::all()->count() }}</span>
                                        <p>+</p>
                                    </div>
                                </div>
                                <h5>Total Product</h5>
                                <p>Sed ut perspiciatis unde omnis iste natus sit accusantium doloremque laudantium
                                    totam.</p>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                            <div class="ab-counter-item mb-30">
                                <div class="ab-counter mb-20">
                                    <div class="counter-icon mr-10">
                                        <img src="{{asset('frontend')}}/img/c-icon-01.png" alt="">
                                    </div>
                                    <div class="counter_info">
                                        <span class="counter">{{ App\Models\Brand::all()->count() }}</span>
                                        <p>+</p>
                                    </div>
                                </div>
                                <h5>Total Brand</h5>
                                <p>Sed ut perspiciatis unde omnis iste natus sit accusantium doloremque laudantium
                                    totam.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- technolgy-index-end -->

<!-- team-area-start -->
<div class="team-area light-bg-s pt-70 pb-40">
    <div class="container">
        <div class="row mb-35">
            <div class="col-xl-12">
                <div class="abs-section-title text-center">
                    <span>THE TEAM</span>
                    <h4>Meet Our Team</h4>
                    <p>The perfect way to enjoy brewing tea on low hanging fruit to identify. Duis autem vel eum iriure
                        dolor in hendrerit <br> in vulputate velit esse molestie consequat, vel illum dolore eu feugiat
                        nulla facilisis.</p>
                </div>
            </div>
        </div>
        <div class="row">
            @forelse ($teams as $team)
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                <div class="single-team text-center mb-30">
                    <div class="team-image mb-35 w-img">
                        <div class="inner-timg">
                            <a href="about.html">
                                <img src="{{asset('uploads/team_member_photo')}}/{{ $team->team_member_photo }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="tauthor-degination mb-15">
                        <h5>{{ $team->team_member_name }}</h5>
                        <span>{{ $team->team_member_designation }}</span>
                    </div>
                    <div class="team-social">
                        <a target="_blank" href="{{ $team->team_member_facebook_link }}"><i class="fab fa-facebook-f"></i></a>
                        <a target="_blank" href="{{ $team->team_member_twitter_link }}"><i class="fab fa-twitter"></i></a>
                        <a target="_blank" href="{{ $team->team_member_instagram_link }}"><i class="fab fa-instagram"></i></a>
                        <a target="_blank" href="{{ $team->team_member_linkedin_link }}"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-xl-12">
                <div class="alert alert-warning text-center" role="alert">
                    <strong>Team Member Not Found!</strong>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
<!-- team-area-end -->
@endsection

@section('custom_script')
<script>

</script>
@endsection
