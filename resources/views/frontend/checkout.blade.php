@extends('frontend.layouts.frontend_master')

@section('title_bar')
Checkout
@endsection

@section('body_content')
<!-- page-banner-area-start -->
<div class="page-banner-area page-banner-height-2" data-background="{{asset('frontend')}}/img/banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-banner-content text-center">
                    <h4 class="breadcrumb-title">Checkout</h4>
                    <div class="breadcrumb-two">
                        <nav>
                            <nav class="breadcrumb-trail breadcrumbs">
                                <ul class="breadcrumb-menu">
                                    <li class="breadcrumb-trail">
                                        <a href="{{route('index')}}"><span>Home</span></a>
                                    </li>
                                    <li class="trail-item">
                                        <span>Checkout</span>
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

<!-- checkout-area-start -->
<section class="checkout-area pt-120 pb-85">
    <div class="container">
        <form action="{{route('checkout.post')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="checkbox-form">
                        <h3>Billing Details</h3>
                        @if (!$shipping_address)
                        <div class="alert alert-info">
                            <strong>Currently your billing address shipping not possible please select different shipping address.</strong>
                        </div>
                        @endif
                        @if (!auth()->user()->division_id || !auth()->user()->district_id || !auth()->user()->phone_number)
                        <div class="alert alert-warning">
                            <strong>Please update billing address in your profile.</strong>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Full Name<span class="required">*</span></label>
                                    <input type="text" name="billing_name" value="{{auth()->user()->name}}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Email Address<span class="required">*</span></label>
                                    <input type="text" name="billing_email" value="{{auth()->user()->email}}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Phone Number<span class="required">*</span></label>
                                    <input type="text" class="@error('billing_phone') is-invalid @enderror" placeholder="Phone Number" name="billing_phone" value="{{old('billing_phone', auth()->user()->phone_number)}}" readonly>
                                    @error('billing_phone')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list country-select">
                                    <label>Division Name <span class="required">*</span></label>
                                    <input type="text" placeholder="Billing Division Name" value="{{ auth()->user()->division_id ? auth()->user()->division->name : '' }}" readonly>
                                    <select name="billing_division_id" class="billing_division_select @error('billing_division_id') is-invalid @enderror d-none" >
                                        <option value="">Select Division</option>
                                        @foreach ($divisions as $division)
                                        <option value="{{$division->division_id}}" @selected($division->division_id == old('billing_division_id', auth()->user()->division_id))>{{$division->division->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('billing_division_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list country-select">
                                    <label>District Name <span class="required">*</span></label>
                                    <input type="text" placeholder="Billing District Name" value="{{ auth()->user()->district_id ? auth()->user()->district->name : '' }}" readonly>
                                    <select name="billing_district_id" id="billing_all_district_list" class="billing_district_select @error('billing_district_id') is-invalid @enderror d-none">
                                        <option value="">Select Division First</option>
                                        @foreach ($districts as $district)
                                        <option value="{{$district->district_id}}" @selected($district->district_id == old('billing_district_id', auth()->user()->district_id))>{{$district->district->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('billing_district_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Address <span class="required">*</span></label>
                                    <textarea class="@error('billing_address') is-invalid @enderror" style="width: 100%" placeholder="Address" name="billing_address" readonly>{{auth()->user()->address}}</textarea>
                                    @error('billing_address')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="different-address">
                            <div class="ship-different-title">
                                <h3>
                                    <label>Ship to a different address?</label>
                                    <input id="ship-box" type="checkbox">
                                </h3>
                            </div>
                            <div id="ship-box-info">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Full Name<span class="required">*</span></label>
                                            <input type="text" placeholder="Full Name" name="shipping_name" value="{{auth()->user()->name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Email Address<span class="required">*</span></label>
                                            <input type="text" placeholder="Email Address" name="shipping_email" value="{{auth()->user()->email}}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Phone Number <span class="required">*</span></label>
                                            <input type="text" placeholder="Phone Number" name="shipping_phone" value="{{auth()->user()->phone_number}}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="country-select">
                                            <label>Division Name <span class="required">*</span></label>
                                            <select style="width: 100%" name="shipping_division_id" class="shipping_division_select">
                                                <option value="">Select Division</option>
                                                @foreach ($divisions as $division)
                                                <option value="{{$division->division_id}}" @selected($division->division_id == old('shipping_division_id', auth()->user()->division_id))>{{$division->division->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="country-select" >
                                            <label>District Name <span class="required">*</span></label>
                                            <select style="width: 100%" name="shipping_district_id" id="shipping_all_district_list" class="shipping_district_select">
                                                <option value="">Select Division First</option>
                                                @foreach ($districts as $district)
                                                <option value="{{$district->district_id}}" @selected($district->district_id == old('shipping_district_id', auth()->user()->district_id))>{{$district->district->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Address <span class="required">*</span></label>
                                            <textarea placeholder="Address" class="form-control" name="shipping_address">{{auth()->user()->address}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="order-notes">
                                <div class="checkout-form-list">
                                    <label>Order Notes</label>
                                    <textarea id="checkout-mess" cols="30" rows="10" name="customer_order_notes"
                                        placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="coupon-accordion mb-3">
                        <!-- ACCORDION START -->
                        <h3>If you don't use a coupon? <span id="showcoupon">Click here to enter your code {{ session('session_coupon_name') }}</span></h3>
                        <div id="checkout_coupon" class="coupon-checkout-content">
                            <span class="text-danger d-none" id="coupon_error"></span>
                            <span class="text-success d-none" id="coupon_success"></span>
                            <div class="coupon-info">
                                <p class="checkout-coupon">
                                    <input id="coupon_input_field" class="input-text" name="coupon_name" value="{{session('session_coupon_name')}}" placeholder="Coupon code" type="text" {{ (session('session_coupon_name')) ? 'disabled' : '' }}>
                                    @if (!session('session_coupon_name'))
                                    <button class="tp-btn-h1" id="apply_coupon_btn" type="submit">Apply coupon</button>
                                    @else
                                    <span class="text-success">Coupon Already Used</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <!-- ACCORDION END -->
                    </div>
                    <div class="your-order mb-30 ">
                        <h3>Your Order</h3>
                        <div class="your-order-table table-responsive">
                            <table>
                                <thead class="bg-light">
                                    <tr>
                                        <th class="product-name p-2">Product</th>
                                        <th class="product-total p-2">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carts as $cart)
                                    <tr class="cart_item">
                                        <td class="product-name p-2">
                                            <span>{{$cart->relationtoproduct->product_name}}</span><br>
                                            <strong> Color: </strong> {{$cart->relationtocolor->color_name}} | <strong>Size: </strong> {{$cart->relationtosize->size_name}}
                                        </td>
                                        <td class="product-total p-2">
                                            <span class="amount"> <strong> {{$cart->cart_qty}} </strong> * <strong> {{$cart->product_current_price}} </strong> = <strong class="product-quantity"> {{$cart->product_current_price * $cart->cart_qty}} </strong></span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr>
                            <table>
                                <thead class="bg-light">
                                    <tr>
                                        <th class="product-name p-2">Item</th>
                                        <th class="product-total p-2">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="cart-subtotal">
                                        <td class="p-2">Cart Subtotal</td>
                                        <td class="p-2"><span class="amount" id="sub_total">{{$sub_total}}</span></td>
                                    </tr>
                                    <tr class="cart-subtotal">
                                        <td class="p-2">Discount Amount</td>
                                        <td class="p-2"><span class="amount" id="discount_amount">{{$discount_amount}}</span></td>
                                    </tr>
                                    <tr class="cart-subtotal">
                                        <td class="p-2">Shipping Amount</td>
                                        <td class="p-2"><span class="amount" id="shipping_charge">{{ $shipping_charge }}</span></td>
                                    </tr>
                                    <tr class="cart-subtotal">
                                        <td class="p-2">Total</td>
                                        <td class="p-2"><span class="amount grand_total">{{ $grand_total }}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="payment-method">
                            <div class="shipping">
                                <span><strong>Payment:</strong> </span>
                                <span class="mx-2">
                                    <input type="radio" value="COD" id="COD" name="payment_method" checked>
                                    <label for="COD">Cash On Delivery</label>
                                </span>
                                <span  class="mx-2">
                                    <input type="radio" value="Online" id="Online" name="payment_method">
                                    <label for="Online">Online</label>
                                </span>
                            </div>
                            <div class="order-button-payment mt-20 text-center">
                                <strong class="text-warning {{ (auth()->user()->division_id && auth()->user()->district_id) || $shipping_address ? 'd-none' : '' }} checkout_warning_btn">Please Select Shipping Division & District Address.</strong>
                                <button type="submit" class="tp-btn-h1 {{ (!auth()->user()->division_id && !auth()->user()->district_id) || !$shipping_address ? 'd-none' : '' }} checkout_btn">Place order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- checkout-area-end -->
@endsection

@section('custom_script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Apply Coupon
        $(document).on('click', '#apply_coupon_btn', function(e){
            e.preventDefault();
            var coupon_name =  $('#coupon_input_field').val();
            var sub_total =  $('#sub_total').html();
            var shipping_charge = $('#shipping_charge').html();
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
                        var grand_total = parseInt(sub_total) + parseInt(shipping_charge);
                        $('.grand_total').html(grand_total);
                    }else{
                        $('#coupon_error').addClass('d-none');
                        $('#coupon_success').removeClass('d-none');
                        $('#coupon_success').html(data.success);
                        $('#discount_amount').html(data.coupon_offer_amount);
                        var grand_total = (data.grand_total) + parseInt(shipping_charge);
                        $('.grand_total').html(grand_total);
                    }
                }
            })
            // ajax end
        })

        // Select Shipping Division
        $('.shipping_division_select').change(function(){
            $('.checkout_btn').addClass('d-none');
            $('.checkout_warning_btn').removeClass('d-none');
            $('#shipping_charge').html("00");
            var sub_total = $('#sub_total').html();
            var discount_amount = $('#discount_amount').html();
            var grand_total = parseInt(sub_total) - parseInt(discount_amount);
            $('.grand_total').html(grand_total);
            var division_id = $(this).val();
            // ajax start
            $.ajax({
                type:'POST',
                url: "{{route('get.district.list')}}",
                data:{division_id:division_id},
                success: function(response){
                    $('#shipping_all_district_list').html(response);
                }
            })
            // ajax end
        })

        // Select Shipping District
        $('.shipping_district_select').change(function(){
            var division_id= $('.shipping_division_select :selected').val();
            var district_id = $(this).val();
            // ajax start
            $.ajax({
                type:'POST',
                url: "{{route('get.shipping.charge')}}",
                data:{division_id:division_id, district_id:district_id},
                success: function(response){
                    $('.checkout_btn').removeClass('d-none');
                    $('.checkout_warning_btn').addClass('d-none');
                    $('#shipping_charge').html(response);
                    var sub_total = $('#sub_total').html();
                    var discount_amount = $('#discount_amount').html();
                    var grand_total = parseInt(sub_total) + parseInt(response) - parseInt(discount_amount);
                    $('.grand_total').html(grand_total);
                }
            })
            // ajax end
        })

        // Select2 Option
        $('.shipping_division_select').select2({
            placeholder: "Select Division"
        });

        $('.shipping_district_select').select2({
            placeholder: "Select District"
        });

    });
</script>
@endsection
