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
            <li>return_status: <strong>{{ $return_details->return_status }}</strong></li>
            <li>created_at: <strong>{{ $return_details->created_at }}</strong></li>
        </ul>
        <ul>
            <li>Return Reason Details: <strong>{{ $return_details->return_reason_details }}</strong></li>
            <li>Return Reason Photo: <strong>{{ $return_details->return_reason_photo }}</strong></li>
            <li>Account Holder Name: <strong>{{ $return_details->account_holder_name }}</strong></li>
            <li>Account Type: <strong>{{ $return_details->account_type }}</strong></li>
            <li>Account Numberr: <strong>{{ $return_details->account_number }}</strong></li>
            <li>Total Price: <strong>{{ $order_details->product_current_price * $order_details->cart_qty }}</strong></li>
        </ul>
    </div>
</div>
<div class="card text-white">
    <div class="card-header text-center">
        <p class="card-text">Order Details Id {{ $order_details->id }}</p>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="bg-info">
                <tr>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Qty</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-white">
                    <td>{{ $order_details->relationToProduct->product_name }}</td>
                    <td>{{ $order_details->product_current_price }}</td>
                    <td>{{ $order_details->cart_qty }}</td>
                    <td>{{ $order_details->product_current_price * $order_details->cart_qty }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
