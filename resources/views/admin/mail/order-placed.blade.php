<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Placed Succesfully</title>
</head>
<body>
    <p>Hello ,</p>

    <p>Thank You For Ordering!</p>

    <div>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Sub Total</td>
                    <td>{{ $order_summery->sub_total }}</td>
                </tr>
                <tr>
                    <td>Discount Amount</td>
                    <td>{{ $order_summery->discount_amount }}</td>
                </tr>
                <tr>
                    <td>Shipping Charge</td>
                    <td>{{ $order_summery->shipping_charge }}</td>
                </tr>
                <tr>
                    <td>Grand Total</td>
                    <td>{{ $order_summery->grand_total }}</td>
                </tr>
                <tr>
                    <td>Payment Method</td>
                    <td>{{ $order_summery->payment_method }}</td>
                </tr>
                <tr>
                    <td>Payment Status</td>
                    <td>{{ $order_summery->payment_status }}</td>
                </tr>
                <tr>
                    <td>Order Status</td>
                    <td>{{ $order_summery->order_status }}</td>
                </tr>
            </tbody>
        </table>
    </div>


    <p>We look forward to communicating more with you. For more information visit our Site.</p>

    <a href="{{ env('APP_URL') }}" target="_blank">Visit Website</a>

    <p>© {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved.</p>
</body>
</html>
