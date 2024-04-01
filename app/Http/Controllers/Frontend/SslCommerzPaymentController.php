<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\Order_placedMail;
use Illuminate\Support\Facades\Mail;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Order_summery;
use Illuminate\Support\Facades\Session;

class SslCommerzPaymentController extends Controller
{

    public function index()
    {
        $post_data = array();
        $post_data['total_amount'] = Session::get('session_final_grand_total'); # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        Order_summery::find(Session::get('session_order_summery_id'))->update([
            'payment_status' => 'Pending',
            'transaction_id' => $post_data['tran_id'],
        ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_details = Order_summery::where('transaction_id', $tran_id)
            ->select('transaction_id', 'payment_status')
            ->first();

        if ($order_details->payment_status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation == TRUE) {
                Order_summery::where('transaction_id', $tran_id)->update([
                    'payment_status' => 'Paid',
                    'transaction_id' => $tran_id,
                ]);

                // Send SMS
                $siteName = env('APP_NAME');
                $order_summery = Order_summery::find(Session::get('session_order_summery_id'));

                $url = "https://bulksmsbd.net/api/smsapi";
                $api_key = env('SMS_API_KEY');
                $senderid = env('SMS_SENDER_ID');
                $number = $order_summery->billing_phone;
                $message = "Hello $order_summery->billing_name, your order place successfully in $siteName.";
                $data = [
                    "api_key" => $api_key,
                    "senderid" => $senderid,
                    "number" => $number,
                    "message" => $message
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);
                curl_close($ch);
                // return $response;

                Mail::to($order_summery->billing_email)
                        ->cc($order_summery->shipping_email)
                        ->send(new Order_placedMail($order_summery));

                return redirect()->route('dashboard')->with('success', 'Order Place Successfully');
            } else {
                Order_summery::where('transaction_id', $tran_id)->update([
                    'payment_status' => 'Failed',
                    'transaction_id' => $tran_id,
                ]);

                return redirect()->route('dashboard')->with('error', 'Transaction is Failed');
            }
        } else if ($order_details->payment_status == 'Paid') {
            return redirect()->route('dashboard')->with('success', 'Transaction is already Successfully');
        } else {
            return redirect()->route('dashboard')->with('error', 'Transaction is Invalid');
        }
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = Order_summery::where('transaction_id', $tran_id)
            ->select('transaction_id', 'payment_status')
            ->first();

        if ($order_details->payment_status == 'Pending') {
            Order_summery::where('transaction_id', $tran_id)->update([
                'payment_status' => 'Failed',
                'transaction_id' => $tran_id,
            ]);
            return redirect()->route('dashboard')->with('error', 'Transaction is Failed');
        } else if ($order_details->payment_status == 'Paid') {
            return redirect()->route('dashboard')->with('success', 'Transaction is already Successfully');
        } else {
            return redirect()->route('dashboard')->with('error', 'Transaction is Invalid');
        }
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = Order_summery::where('transaction_id', $tran_id)
            ->select('transaction_id', 'payment_status')
            ->first();

        if ($order_details->payment_status == 'Pending') {
            Order_summery::where('transaction_id', $tran_id)->update([
                'payment_status' => 'Canceled',
                'transaction_id' => $tran_id,
            ]);
            return redirect()->route('dashboard')->with('error', 'Transaction is Cancel');
        } else if ($order_details->payment_status == 'Paid') {
            return redirect()->route('dashboard')->with('success', 'Transaction is already Successfully');
        } else {
            return redirect()->route('dashboard')->with('error', 'Transaction is Invalid');
        }


    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {
            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = Order_summery::where('transaction_id', $tran_id)
            ->select('transaction_id', 'payment_status')
            ->first();

            if ($order_details->payment_status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    Order_summery::where('transaction_id', $tran_id)->update([
                        'payment_status' => 'Paid',
                        'transaction_id' => $tran_id,
                    ]);
                    return redirect()->route('dashboard')->with('success', 'Transaction is Successfully');
                } else {
                    Order_summery::where('transaction_id', $tran_id)->update([
                        'payment_status' => 'Failed',
                        'transaction_id' => $tran_id,
                    ]);
                    return redirect()->route('dashboard')->with('error', 'Transaction is Failed');
                }

            } else if ($order_details->payment_status == 'Paid') {
                return redirect()->route('dashboard')->with('success', 'Transaction is already Successfully');
            } else {
                return redirect()->route('dashboard')->with('error', 'Transaction is Invalid');
            }
        } else {
            return redirect()->route('dashboard')->with('error', 'Transaction is Error');
        }
    }

}
