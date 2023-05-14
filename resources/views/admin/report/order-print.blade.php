<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ env('APP_NAME') }}</h4>
        <p class="card-text">Payment Method: {{ ($payment_method) ? $payment_method : "COD & Online" }}</p>
        <p class="card-text">Payment Status: {{ ($payment_status) ? $payment_status : "Paid & Unpaid" }}</p>
        <p class="card-text">Order Status: {{ ($order_status) ? $order_status : "Panding & Received & On the way & Delivered & Cancel" }}</p>
        <p class="card-text">Order Start Start: {{ ($created_at_start) ? $created_at_start : "N/A" }}</p>
        <p class="card-text">Order End Date: {{ ($created_at_end) ? $created_at_end : "N/A" }}</p>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Order No</th>
                        <th>User Name</th>
                        <th>Sub Total</th>
                        <th>Discount Amount</th>
                        <th>Shipping Charge</th>
                        <th>Grand Total</th>
                        <th>Payment Method</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($all_order as $order)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->sub_total }}</td>
                        <td>{{ $order->discount_amount }}</td>
                        <td>{{ $order->shipping_charge }}</td>
                        <td>{{ $order->grand_total }}</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>{{ $order->payment_status }}</td>
                        <td>{{ $order->order_status }}</td>
                        <td>{{ $order->created_at }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="50">Order Not Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <p class="card-text">Report Print Date : {{ date('d M Y') }}</p>
    </div>
</div>
