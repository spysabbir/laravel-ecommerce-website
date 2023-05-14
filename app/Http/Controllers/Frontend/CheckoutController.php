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
            $shippings = Shipping::where('status', "Yes")->select('country_id')->groupBy('country_id')->get();
            $carts = Cart::where('user_id', auth()->user()->id)->where('status', 'Yes')->get();

            $sub_total = 0;
            foreach($carts as $cart){
                $sub_total += ($cart->product_current_price * $cart->cart_qty);
            }

            if(Session::get('session_coupon_name')){
                $coupon = Coupon::where('coupon_name', Session::get('session_coupon_name'))->first();
                if($coupon->coupon_offer_type == 'percentage'){
                    $discount_amount = $coupon->coupon_offer_amount/100;
                    $grand_total = ($sub_total - $coupon->coupon_offer_amount/100);
                }else{
                    $discount_amount = $coupon->coupon_offer_amount;
                    $grand_total = ($sub_total - $coupon->coupon_offer_amount);
                }
            }else{
                $discount_amount = "00";
                $grand_total = $sub_total;
            }

            Session::put('session_sub_total', $sub_total);
            Session::put('session_grand_total', $grand_total);
            Session::put('session_discount_amount', $discount_amount);
            return view('frontend.checkout', compact('shippings', 'carts', 'sub_total', 'discount_amount', 'grand_total'));
        }
    }

    public function getCityList(Request $request){
        $select_city_details = "<option value=''>--Select City--</option>";
        $ul_city_details = "";
        $cities = Shipping::where('country_id', $request->country_id)->get();
        foreach($cities as $city){
            $select_city_details .= "<option value='$city->shipping_charge'>$city->city_name</option>";
            $ul_city_details .= "<li data-value='$city->shipping_charge' class='option'>$city->city_name</li>";
        }
        return response()->json([
            'select_city_details' => $select_city_details,
            'ul_city_details' => $ul_city_details,
        ]);
    }

    public function setCountryCity(Request $request)
    {
        Session::put('session_country_id', $request->country_id);
        Session::put('session_city_name', $request->city_name);
    }

    public function checkoutPost(Request $request)
    {
        $request->validate([
            'billing_phone' => 'required',
            'billing_address' => 'required',
        ]);

        $shipping_charge =  Shipping::where([
            'country_id' => Session::get('session_country_id'),
            'city_name' => Session::get('session_city_name'),
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

        $grand_total = Session::get('session_grand_total') + $shipping_charge;

        $order_summery_id = Order_summery::insertGetId([
            'user_id' => auth()->id(),
            'billing_name' => $request->billing_name,
            'billing_email' => $request->billing_email,
            'billing_phone' => $request->billing_phone,
            'country_id' => Session::get('session_country_id'),
            'city_name' => Session::get('session_city_name'),
            'billing_address' => $request->billing_address,
            'shipping_name' => $request->shipping_name,
            'shipping_email' => $request->shipping_email,
            'shipping_phone' => $shipping_phone,
            'shipping_country' => $request->shipping_country,
            'shipping_city' => $request->shipping_city,
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
            // $url = "https://bulksmsbd.net/api/smsapi";
            // $api_key = "VjkIEblFGYFP7yH5NyOk";
            // $senderid = "03590740020";
            // $number = "$request->billing_phone";
            // $message = "Hello $request->billing_name, your Order place successfully in eCommerce";
            // $data = [
            //     "api_key" => $api_key,
            //     "senderid" => $senderid,
            //     "number" => $number,
            //     "message" => $message
            // ];
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // $response = curl_exec($ch);
            // curl_close($ch);
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
