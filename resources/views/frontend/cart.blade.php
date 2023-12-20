@extends('frontend.layouts.frontend_master')

@section('title_bar')
Cart
@endsection

@section('body_content')
<!-- page-banner-area-start -->
<div class="page-banner-area page-banner-height-2" data-background="{{ asset('frontend') }}/img/banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-banner-content text-center">
                    <h4 class="breadcrumb-title">Your Cart</h4>
                    <div class="breadcrumb-two">
                        <nav>
                            <nav class="breadcrumb-trail breadcrumbs">
                                <ul class="breadcrumb-menu">
                                    <li class="breadcrumb-trail">
                                        <a href="{{ route('index') }}"><span>Home</span></a>
                                    </li>
                                    <li class="trail-item">
                                        <span>Cart</span>
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

<!-- cart-area-start -->
<section class="cart-area pt-120 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="table-content table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="">Select</th>
                                <th class="product-thumbnail">Images</th>
                                <th class="cart-product-name">Product</th>
                                <th class="product-price">Unit Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-subtotal">Total Price</th>
                                <th class="product-remove">Action</th>
                            </tr>
                        </thead>
                        <tbody id="all_cart_data">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="coupon-all mb-3">
                    <div class="coupon">
                       <input id="coupon_input_field" class="input-text" name="coupon_name" value="" placeholder="Coupon code" type="text">
                       <button class="tp-btn-h1" id="apply_coupon_btn" type="submit">Apply coupon</button>
                       <a href="#" id="remove_coupon_btn" class="text-danger p-2"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <span class="text text-danger d-none" id="coupon_error"></span>
                <span class="text text-info d-none" id="coupon_success"></span>
            </div>
            <div class="col-lg-4">
                <div class="cart-page-total">
                    <h2>Cart totals</h2>
                    <ul class="mb-20">
                        <li>Sub Total: <span id="sub_total">00</span> <strong>৳</strong></li>
                        <li>Coupon Discount: (-) <span id="discount_amount">00</span><strong id="offer_type"></strong></li>
                        <li>Grand Total: <span id="grand_total">00</span> <strong>৳</strong></li>
                    </ul>
                    <a class="tp-btn-h1 d-none" id="checkout_btn" href="{{ route('checkout') }}">Proceed to checkout</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- cart-area-end -->
@endsection

@section('custom_script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Read Header Cart Data
        function fetchHeaderCart(){
            $.ajax({
                url: '{{ route('fetch.header.cart') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#header_cart_data').html(response.cart_data);
                    $('#header_cart_count').html(response.cart_count);
                    $('.header_cart_sub_total').html(response.cart_sub_total);
                }
            });
        }

        // Read Data
        fetchAllCart();
        function fetchAllCart(){
            $.ajax({
                url: '{{ route('fetch.cart') }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#all_cart_data').html(response.carts_data);
                    $('#sub_total').html(response.carts_sub_total);
                    $('#grand_total').html(response.grand_total);
                    if(response.grand_total != 0){
                        $('#checkout_btn').removeClass('d-none');
                    }else{
                        $('#checkout_btn').addClass('d-none');
                    }
                }
            });
        }

        // Cart QTY Increment
        $(document).on('click', '.inc', function(e){
            e.preventDefault();
            let cart_item_id = $(this).attr('id');
            // ajax start
            $.ajax({
                type:'POST',
                url: "{{route('cart.item.inc')}}",
                data:{cart_item_id:cart_item_id},
                success: function(response) {
                    if (response.status == 200) {
                        fetchAllCart();
                        fetchHeaderCart();
                    } else {
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
                            icon: 'warning',
                            title: 'Maximum Cart Quantity Limit is 5'
                        })
                    }
                }
            })
            // ajax end
        })

        // Cart QTY Decrement
        $(document).on('click', '.dec', function(e){
            e.preventDefault();
            let cart_item_id = $(this).attr('id');
            // ajax start
            $.ajax({
                type:'POST',
                url: "{{route('cart.item.dec')}}",
                data:{cart_item_id:cart_item_id},
                success: function(response) {
                    if (response.status == 200) {
                        fetchAllCart();
                        fetchHeaderCart();
                    } else {
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
                            icon: 'warning',
                            title: 'Minimum Cart Quantity Limit is 1.'
                        })
                    }
                }
            })
            // ajax end
        })

        // Force Delete
        $(document).on('click', '.deleteCartBtn', function (e) {
            e.preventDefault();
            let id = $(this).attr('id');
            var url = "{{ route('cart.forcedelete', ":id") }}";
            url = url.replace(':id', id)
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function (response) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-center',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter',
                                        Swal.stopTimer)
                                    toast.addEventListener('mouseleave',
                                        Swal.resumeTimer)
                                }
                            })
                            Toast.fire({
                                icon: 'warning',
                                title: 'Cart item force delete successfully'
                            })
                            fetchAllCart();
                            fetchHeaderCart();
                        }
                    });
                }
            })
        })

        // Status Change
        $(document).on('change', '.status_change', function(e){
            let id = $(this).attr('id');
            var url = "{{ route('change.cart.status', ":id") }}";
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
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
                    title: 'Cart status change successfully'
                    })
                    fetchAllCart();
                }
            });

        })

        // Apply Coupon
        $(document).on('click', '#apply_coupon_btn', function(e){
            e.preventDefault();
            var coupon_name =  $('#coupon_input_field').val();
            var sub_total =  $('#sub_total').html();
            // ajax start
            $.ajax({
                type:'POST',
                url: "{{route('check.coupon')}}",
                data:{coupon_name:coupon_name, sub_total:sub_total},

                success: function(data){
                    if(data.status == 400){
                        $('#coupon_error').html(data.error);
                        $('#coupon_success').addClass('d-none');
                        $('#coupon_error').removeClass('d-none');
                        $('#discount_amount').html("00");
                        $('#grand_total').html(sub_total);
                    }else{
                        $('#coupon_error').addClass('d-none');
                        $('#coupon_success').removeClass('d-none');
                        $('#coupon_success').html(data.success);
                        $('#discount_amount').html(data.coupon_offer_amount);
                        $('#offer_type').html(data.coupon_offer_type);
                        $('#grand_total').html(data.grand_total);
                    }
                }
            })
            // ajax end
        })

        // Remove Coupon
        $(document).on('click', '#remove_coupon_btn', function(e){
            e.preventDefault();
            var sub_total =  $('#sub_total').html();
            // ajax start
            $.ajax({
                type:'GET',
                url: "{{ route('remove.coupon') }}",
                success: function(data){
                    if(data.status == 400){
                        $('#coupon_error').html(data.error);
                        $('#coupon_error').removeClass('d-none');
                        $('#coupon_success').addClass('d-none');
                    }else{
                        $('#coupon_error').addClass('d-none');
                        $('#coupon_success').removeClass('d-none');
                        $('#coupon_success').html(data.success);
                        $('#discount_amount').html("00");
                        $('#grand_total').html(sub_total);
                        $('#coupon_input_field').val("");
                    }
                }
            })
            // ajax end
        })
    });
</script>
@endsection
