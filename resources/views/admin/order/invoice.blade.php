<style>
    body {
        font-family: Helvetica, sans-serif;
        font-size: 13px;
    }

    .container {
        max-width: 680px;
        margin: 0 auto;
    }

    .logotype {
        background: #000;
        color: #fff;
        width: 75px;
        height: 50px;
        line-height: 50px;
        text-align: center;
        font-size: 11px;
    }

    .column-title {
        background: #eee;
        text-transform: uppercase;
        padding: 15px 5px 15px 15px;
        font-size: 11px
    }

    .column-detail {
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
    }

    .column-header {
        background: #eee;
        text-transform: uppercase;
        padding: 15px;
        font-size: 11px;
        border-right: 1px solid #eee;
    }

    .row {
        padding: 7px 14px;
        border-left: 1px solid #eee;
        border-right: 1px solid #eee;
        border-bottom: 1px solid #eee;
    }

    .alert {
        background: #ffd9e8;
        padding: 20px;
        margin: 20px 0;
        line-height: 22px;
        color: #333
    }

    .socialmedia {
        background: #eee;
        padding: 20px;
        display: inline-block;
        margin-top: 10px;
    }
</style>

@php
$default_setting = App\Models\Default_setting::first();
@endphp

<div class="container">
    <table width="100%">
        <tr>
            <td width="25%">
                <div class="logotype">{{env('APP_NAME')}}</div>
            </td>
            <td width="20%">
                <div
                    style="background: #ffd9e8;border-left: 15px solid #fff;padding-left: 10px;font-size: 26px;font-weight: bold;letter-spacing: -1px;height: 50px;line-height: 50px;">
                    Invoice No: #{{$order_summery->id}}
                </div>
            </td>
        </tr>
    </table>
    <br>
    <table width="100%" style="border-collapse: collapse;">
        <tr>

            <td widdth="50%" style="background:#eee;padding:20px;">
                <h3>Business Details:</h3>
                <strong>Name:</strong> {{env('APP_NAME')}}<br>
                <strong>E-mail:</strong> {{$default_setting->support_email}}<br>
                <strong>Phone:</strong> {{$default_setting->support_phone}}<br>
                <strong>Address:</strong> {{$default_setting->address}}<br>
            </td>
            <td style="background:#eee;padding:20px;">
                <h3>Order Details:</h3>
                <strong>Date:</strong> {{$order_summery->created_at->format('M d, Y h:m A')}}<br>
                <strong>Payment type:</strong> {{$order_summery->payment_method}}<br>
                <strong>Payment status:</strong> {{$order_summery->payment_status}}<br>
                <strong>Order status:</strong> {{$order_summery->order_status}}<br>
            </td>
        </tr>
    </table>
    <br>
    <table width="100%">
        <tr>
            <td>
                <table>
                    <tr>
                        <td>
                            <strong>Billing Address</strong><br>
                            {{$order_summery->billing_name}}<br>
                            {{$order_summery->billing_email}}<br>
                            {{$order_summery->billing_phone}}<br>
                            {{$order_summery->billing_address}}
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td>
                            <strong>Delivery Address</strong><br>
                            {{$order_summery->shipping_name}}<br>
                            {{$order_summery->shipping_email}}<br>
                            {{$order_summery->shipping_phone}}<br>
                            {{$order_summery->shipping_address}}<br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>

    <table width="100%" style="border-top:1px solid #eee;border-bottom:1px solid #eee;padding:0 0 8px 0">
        <tr>
            <td>
                <strong>Customer Order Notes:</strong>
                {{$order_summery->customer_order_notes}}
            <td>
        </tr>
    </table>
    <br>

    <h3>Your Order</h3>
    <table width="100%" style="border-collapse: collapse;border-bottom:1px solid #eee;">
        <tr>
            <td width="45%" class="column-header">Product Name</td>
            <td width="15%" class="column-header">Color</td>
            <td width="15%" class="column-header">Size</td>
            <td width="15%" class="column-header">QTY * Price</td>
            <td width="10%" class="column-header">Total Price</td>
        </tr>
        @foreach ($order_details as $order_detail)
        <tr>
            <td class="row">{{$order_detail->relationtoproduct->product_name}}</td>
            <td class="row">{{$order_detail->relationtocolor->color_name}}</td>
            <td class="row">{{$order_detail->relationtosize->size_name}}</td>
            <td class="row">{{$order_detail->cart_qty}} * {{$order_detail->product_current_price}}</td>
            <td class="row">{{$order_detail->cart_qty * $order_detail->product_current_price}}</td>
        </tr>
        @endforeach

    </table>
    <br>
    <table width="100%" style="background:#eee;padding:20px;">
        <tr style="text-align:right">
            <td><strong>Sub Total:</strong></td>
            <td>{{$order_summery->sub_total}}</td>
        </tr>
        <tr style="text-align:right">
            <td><strong>Shipping Fee:</strong></td>
            <td>{{$order_summery->shipping_charge}}</td>
        </tr>
        <tr style="text-align:right">
            <td><strong>Discount Amount:</strong></td>
            <td>{{$order_summery->discount_amount}}</td>
        </tr>
        <tr style="text-align:right">
            <td><strong>Grand Total:</strong></td>
            <td>{{$order_summery->grand_total}}</td>
        </tr>
    </table>
    <br>
    <span style="float:right">
        <strong>Total Amount in Words:</strong>
        {{ Str::ucfirst(Terbilang::make($order_summery->grand_total))}} Taka Only
    </span>
    <br>
    <div class="" style="text-align: center">

    </div>
    <div class="socialmedia" style="text-align: center; width:100%">
        This is a system generated report. Power by {{env('APP_NAME')}}
    </div>
</div>
<!-- container -->
