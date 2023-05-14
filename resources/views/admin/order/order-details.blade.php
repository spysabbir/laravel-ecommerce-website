<h4 class="text-center mb-3">Order No: <strong>#{{ $order_summery->id }}</strong></h4>
<div class="card text-white">
    <div class="card-header text-center">
        <p class="card-text">Order Summery</p>
    </div>
    <div class="card-body d-flex">
        <ul>
            <li>User Id: <strong>{{ $order_summery->relationtouser->id }}</strong></li>
            <li>User Name: <strong>{{ $order_summery->relationtouser->name }}</strong></li>
            <li>User Email: <strong>{{ $order_summery->relationtouser->email }}</strong></li>
            <li>User Phone Number: <strong>{{ $order_summery->relationtouser->phone_number }}</strong></li>
            <li>Shipping Name: <strong>{{ $order_summery->shipping_name }}</strong></li>
            <li>Shipping Phone: <strong>{{ $order_summery->shipping_phone }}</strong></li>
            <li>Shipping Country: <strong>{{ $order_summery->shipping_country }}</strong></li>
            <li>Shipping City: <strong>{{ $order_summery->shipping_city }}</strong></li>
            <li>Shipping Address: <strong>{{ $order_summery->shipping_address }}</strong></li>
            <li>Customer Order Notes: <strong>{{ $order_summery->customer_order_notes }}</strong></li>
        </ul>
        <ul>
            <li>Sub Total: <strong>{{ $order_summery->sub_total }}</strong></li>
            <li>Coupon Name: <strong>{{ $order_summery->coupon_name }}</strong></li>
            <li>Discount Amount: <strong>{{ $order_summery->discount_amount }}</strong></li>
            <li>Shipping Charge: <strong>{{ $order_summery->shipping_charge }}</strong></li>
            <li>Grand Total: <strong>{{ $order_summery->grand_total }}</strong></li>
            <li>Payment Method: <strong>{{ $order_summery->payment_method }}</strong></li>
            <li>Payment Status: <strong>{{ $order_summery->payment_status }}</strong></li>
            <li>Transaction Id: <strong>{{ $order_summery->transaction_id }}</strong></li>
            <li>Order Status: <strong>{{ $order_summery->order_status }}</strong></li>
            <li>Created At: <strong>{{ $order_summery->created_at }}</strong></li>
        </ul>
    </div>
</div>
<div class="card text-white">
    <div class="card-header text-center">
        <p class="card-text">Order Details</p>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="bg-info">
                <tr>
                    <th>Product Name</th>
                    <th>Color Name</th>
                    <th>Size Name</th>
                    <th>Product Price</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order_details as $item)
                <tr class="text-white">
                    <td>{{ $item->relationToProduct->product_name }}</td>
                    <td>{{ $item->relationToColor->color_name }}</td>
                    <td>{{ $item->relationToSize->size_name }}</td>
                    <td>{{ $item->product_current_price }}</td>
                    <td>{{ $item->cart_qty }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
