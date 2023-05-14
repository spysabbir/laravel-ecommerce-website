@extends('frontend.layouts.frontend_master')

@section('title_bar')
Order Tracking
@endsection

@section('body_content')
<!-- page-banner-area-start -->
<div class="page-banner-area page-banner-height-2" data-background="{{asset('frontend')}}/img/banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-banner-content text-center">
                    <h4 class="breadcrumb-title">Order Tracking</h4>
                    <div class="breadcrumb-two">
                        <nav>
                            <nav class="breadcrumb-trail breadcrumbs">
                                <ul class="breadcrumb-menu">
                                    <li class="breadcrumb-trail">
                                        <a href="{{route('index')}}"><span>Home</span></a>
                                    </li>
                                    <li class="trail-item">
                                        <span>Order Tracking</span>
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
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Order Details</h4>
                        <p class="card-text">Result</p>
                    </div>
                    <div class="card-body">
                        <ul id="order_status_result">
                            <div class="alert alert-info">
                                <strong>Input your order email & order number...</strong>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="card">
                    <div class="card-header bg-info">
                        <h4 class="card-title">Check Order Status</h4>
                        <p class="card-text">Input your order email & order number...</p>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Order Email</label>
                            <input type="text" class="form-control" id="order_email" name="order_email"
                                placeholder="Order Email">
                            <span class="text-danger error-text order_email_error"></span>
                            <span class="text-danger" id="order_email_error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Order Number</label>
                            <input type="text" class="form-control" id="order_number" name="order_number"
                                placeholder="Order Number">
                            <span class="text-danger error-text order_number_error"></span>
                            <span class="text-danger" id="order_number_error"></span>
                        </div>
                        <div id="order_summery"></div>
                        <button class="btn btn-info" type="submit" id="orderTrackingBtn">Check Order Status</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- about-area-end -->
@endsection

@section('custom_script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Check Order Status
        $(document).on('click', '#orderTrackingBtn', function (e) {
            e.preventDefault();
            var order_email = $('#order_email').val();
            var order_number = $('#order_number').val();
            $("#orderTrackingBtn").text('Checking...');
            // ajax start
            $.ajax({
                type: 'POST',
                url: "{{route('check.order.status')}}",
                data: {
                    order_email: order_email,
                    order_number: order_number
                },
                beforeSend: function () {
                    $(document).find('span.error-text').text('');
                },
                success: function (response) {
                    if (response.status == 400) {
                        $.each(response.error, function (prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        })
                    } else {
                        if (response.status == 401) {
                            $('#order_email_error').html("");
                            $('#order_email_error').html("Email Not Match");
                        } else {
                            if (response.status == 402) {
                                $('#order_number_error').html("");
                                $('#order_number_error').html("Order Number Not Match");
                            } else {
                                $('#order_status_result').html(response.order_status);
                                $('#order_email_error').html("");
                                $('#order_number_error').html("");
                                $("#orderTrackingBtn").text('Checking Done........');
                            }
                        }
                    }
                }
            })
            // ajax end
        })
    });
</script>
@endsection
