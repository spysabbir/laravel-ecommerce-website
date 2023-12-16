<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\Order_placedMail;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order_detail;
use App\Models\Order_summery;
use App\Models\Product_inventory;
use Illuminate\Http\Request;
use App\Models\Shipping;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class CheckoutController extends Controller
{
    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        } else {
            $divisions = Shipping::where('status', 'Yes')->groupBy('division_id')->select('division_id')->get();
            $districts = Shipping::where('status', 'Yes')->where('division_id', Auth::user()->division_id)->groupBy('district_id')->select('district_id')->get();
            $carts = Cart::where('user_id', auth()->user()->id)->where('status', 'Yes')->get();

            $sub_total = 0;
            foreach($carts as $cart){
                $sub_total += ($cart->product_current_price * $cart->cart_qty);
            }

            $shipping_charge = Shipping::where('division_id', Auth::user()->division_id)->where('district_id', Auth::user()->district_id)->value('shipping_charge');
            if($shipping_charge){
                $shipping_charge = $shipping_charge;
            }else{
                $shipping_charge = 0;
            }

            if(Session::get('session_coupon_name')){
                $coupon = Coupon::where('coupon_name', Session::get('session_coupon_name'))->first();
                if($coupon->coupon_offer_type == 'percentage'){
                    $discount_amount = $coupon->coupon_offer_amount/100;
                    $grand_total = ($sub_total - $coupon->coupon_offer_amount/100) + $shipping_charge;
                }else{
                    $discount_amount = $coupon->coupon_offer_amount;
                    $grand_total = ($sub_total - $coupon->coupon_offer_amount) + $shipping_charge;
                }
            }else{
                $discount_amount = 0;
                $grand_total = $sub_total + $shipping_charge;
            }

            Session::put('session_sub_total', $sub_total);
            Session::put('session_grand_total', $grand_total);
            Session::put('session_discount_amount', $discount_amount);
            return view('frontend.checkout', compact('divisions', 'districts', 'carts', 'sub_total', 'discount_amount', 'shipping_charge', 'grand_total'));
        }
    }

    public function getDistrictList(Request $request){
        $get_district_list = "<option value=''>Select District</option>";
        $shippings = Shipping::with('district')->where('division_id', $request->division_id)->get();
        foreach($shippings as $shipping){
            $district_name = $shipping->district->name;
            $get_district_list .= "<option value='$shipping->district_id'>$district_name</option>";
        }
        return response()->json($get_district_list);
    }

    public function getShippingCharge(Request $request)
    {
        Session::put('session_division_id', $request->division_id);
        Session::put('session_district_id', $request->district_id);

        $shipping_charge = Shipping::where('division_id', $request->division_id)
                        ->where('district_id', $request->district_id)
                        ->value('shipping_charge');
        return response()->json($shipping_charge);
    }

    public function checkoutPost(Request $request)
    {
        $request->validate([
            'billing_phone' => 'required',
            'billing_address' => 'required',
            'billing_division_id' => 'required',
            'billing_district_id' => 'required',
        ]);

        $shipping_charge =  Shipping::where([
            'division_id' => Session::get('session_division_id'),
            'district_id' => Session::get('session_district_id'),
        ])->first()->shipping_charge;

        if ($request->shipping_address == NULL) {
            $shipping_address = $request->billing_address;
        } else {
            $shipping_address = $request->shipping_address;
        }
        if ($request->shipping_phone == NULL) {
            $shipping_phone = $request->billing_phone;
        } else {
            $shipping_phone = $request->shipping_phone;
        }

        $grand_total = Session::get('session_sub_total') - Session::get('session_discount_amount') + $shipping_charge;

        $order_summery_id = Order_summery::insertGetId([
            'user_id' => auth()->id(),
            'billing_name' => $request->billing_name,
            'billing_email' => $request->billing_email,
            'billing_phone' => $request->billing_phone,
            'billing_division_id' => $request->billing_division_id,
            'billing_district_id' => $request->billing_district_id,
            'billing_address' => $request->billing_address,
            'shipping_name' => $request->shipping_name,
            'shipping_email' => $request->shipping_email,
            'shipping_phone' => $shipping_phone,
            'shipping_division_id' => Session::get('session_division_id'),
            'shipping_district_id' => Session::get('session_district_id'),
            'shipping_address' => $shipping_address,
            'customer_order_notes' => $request->customer_order_notes,
            'payment_method' => $request->payment_method,
            'sub_total' => Session::get('session_sub_total'),
            'shipping_charge' => $shipping_charge,
            'coupon_name' => Session::get('session_coupon_name'),
            'discount_amount' => Session::get('session_discount_amount'),
            'grand_total' => $grand_total,
            'created_at' => Carbon::now(),
        ]);

        $cart_products =  Cart::where('user_id', auth()->id())->where('status', 'Yes')->get();
        foreach($cart_products as $cart_product){
            Order_detail::insert([
                'order_no' => $order_summery_id,
                'product_id' => $cart_product->product_id,
                'product_current_price' => $cart_product->product_current_price,
                'color_id' => $cart_product->color_id,
                'size_id' => $cart_product->size_id,
                'cart_qty' => $cart_product->cart_qty,
                'created_at' => Carbon::now(),
            ]);
            // Decrement at inventory
            Product_inventory::where([
                'product_id' => $cart_product->product_id,
                'color_id' => $cart_product->color_id,
                'size_id' => $cart_product->size_id,
            ])->decrement('quantity', $cart_product->cart_qty);
            // Delete for cart
            $cart_product->delete();
        }

        if(Session::get('session_coupon_name')){
            Coupon::where('coupon_name', Session::get('session_coupon_name'))->decrement('coupon_user_limit');
        }

        if($request->payment_method == 'Online'){
            Session::put('session_order_summery_id', $order_summery_id);
            Session::put('session_final_grand_total', $grand_total);
            return redirect('pay');
        }else{
            // Send SMS
            $siteName = env('APP_NAME');

            $url = "https://bulksmsbd.net/api/smsapi";
            $api_key = env('SMS_API_KEY');
            $senderid = env('SMS_SENDER_ID');
            $number = "$request->billing_phone";
            $message = "Hello $request->billing_name, your order place successfully in $siteName. Your order no $order_summery_id.";
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

            $order_summery = Order_summery::find($order_summery_id);
            Mail::to($order_summery->billing_email)
                ->cc($order_summery->shipping_email)
                ->send(new Order_placedMail($order_summery));

            return redirect()->route('dashboard')->with('success', 'Order Place Successfully.');
        }
    }

    public function laterPay($grand_total, $order_summery_id)
    {
        Session::put('session_final_grand_total', $grand_total);
        Session::put('session_order_summery_id', $order_summery_id);
        return redirect('pay');
    }
}
