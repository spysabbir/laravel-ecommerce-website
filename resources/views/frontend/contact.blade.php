@extends('frontend.layouts.frontend_master')

@section('title_bar')
Contact Us
@endsection

@section('body_content')

<!-- page-banner-area-start -->
<div class="page-banner-area page-banner-height-2" data-background="{{asset('frontend')}}/img/banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-banner-content text-center">
                    <h4 class="breadcrumb-title">Contact Us</h4>
                    <div class="breadcrumb-two">
                        <nav>
                            <nav class="breadcrumb-trail breadcrumbs">
                                <ul class="breadcrumb-menu">
                                    <li class="breadcrumb-trail">
                                        <a href="{{route('index')}}"><span>Home</span></a>
                                    </li>
                                    <li class="trail-item">
                                        <span>Contact Us</span>
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

<!-- location-area-start -->
<div class="location-area pt-70 pb-25">
    <div class="container">
        <div class="row mb-25">
            <div class="col-xl-12">
                <div class="abs-section-title text-center">
                    <h4>Where We Are</h4>
                    <p>The perfect way to enjoy brewing tea on low hanging fruit to identify. Duis autem vel eum iriure
                        dolor in hendrerit <br> in vulputate velit esse molestie consequat, vel illum dolore eu feugiat
                        nulla facilisis.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <p class="card-text">Contact Details</p>
                    </div>
                    <div class="card-body">
                        <div class="location-item mb-30">
                            <div class="sm-item-loc sm-item-border mb-20">
                                <div class="sml-icon mr-20">
                                    <i class="fal fa-map-marker-alt"></i>
                                </div>
                                <div class="sm-content">
                                    <span>Find us</span>
                                    <p>{{$default_setting->address}}</p>
                                </div>
                            </div>
                            <div class="sm-item-loc sm-item-border mb-20">
                                <div class="sml-icon mr-20">
                                    <i class="fal fa-phone-alt"></i>
                                </div>
                                <div class="sm-content">
                                    <span>Call us</span>
                                    <p><a href="tel:{{$default_setting->main_phone}}">{{$default_setting->main_phone}}</a></p>
                                    <p><a href="tel:{{$default_setting->support_phone}}">{{$default_setting->support_phone}}</a></p>
                                </div>
                            </div>
                            <div class="sm-item-loc mb-20">
                                <div class="sml-icon mr-20">
                                    <i class="fal fa-envelope"></i>
                                </div>
                                <div class="sm-content">
                                    <span>Mail us</span>
                                    <p><a href="mailto:{{$default_setting->main_email}}">{{$default_setting->main_email}}</a></p>
                                    <p><a href="mailto:{{$default_setting->support_email}}">{{$default_setting->support_email}}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <p class="card-text">Contact Us</p>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST" id="contactMessageForm">
                            @csrf
                            <div class="form-group mb-2">
                                <input type="text" name="full_name" class="form-control" placeholder="Your Full Name">
                                <span class="text-danger error-text full_name_error"></span>
                            </div>
                            <div class="form-group mb-2">
                                <input type="email" name="email_address" class="form-control" placeholder="Your Email">
                                <span class="text-danger error-text email_address_error"></span>
                            </div>
                            <div class="form-group mb-2">
                                <input type="text" name="phone_number" class="form-control" placeholder="Your Phone Number">
                                <span class="text-danger error-text phone_number_error"></span>
                            </div>
                            <div class="form-group mb-2">
                                <input type="Subject" name="subject" class="form-control" placeholder="Your Subject">
                                <span class="text-danger error-text subject_error"></span>
                            </div>
                            <div class="form-group mb-2">
                                <textarea name="message" class="form-control" placeholder="Your Message"></textarea>
                                <span class="text-danger error-text message_error"></span>
                            </div>
                            <div class="form-group mb-2">
                                <button type="submit" id="contactMessageBtn" class="btn btn-info btn-sm">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- location-area-end -->

<!-- cmamps-area-start -->
<div class="cmamps-area">
    {!! $default_setting->google_map_link !!}
</div>
<!-- cmamps-area-end -->
@endsection

@section('custom_script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Send Message
        $("#contactMessageForm").submit(function(e) {
            e.preventDefault();
            const form_data = new FormData(this);
            $("#contactMessageBtn").text('Sending.....');
            $.ajax({
                url: '{{ route('contact.message.send') }}',
                method: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                },
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.error, function(prefix, val){
                            $('span.'+prefix+'_error').text(val[0]);
                        })
                    }else{
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-center',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        Toast.fire({
                            icon: 'success',
                            title: 'Contact message successfully'
                        })
                        $("#contactMessageBtn").text('Send Message...');
                        $("#contactMessageForm")[0].reset();
                    }
                }
            });
        });
    });
</script>
@endsection
