<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function cart()
    {
        Session::put('session_coupon_name', '');
        Cart::where('user_id', Auth::user()->id)->update(['status' =>  'No']);
        return view('frontend.cart');
    }

    public function buyNow(Request $request){
        Cart::where('user_id', Auth::user()->id)->update(['status' =>  'No']);
        Cart::insert([
            'user_id' => $request-> user_id,
            'product_id' => $request-> product_id,
            'color_id' => $request-> color_id,
            'size_id' => $request-> size_id,
            'product_current_price' => $request-> product_current_price,
            'cart_qty' => $request-> cart_qty,
            'status' => 'Yes',
            'created_at' => Carbon::now(),
        ]);
        return response()->json([
            'status' => 200,
        ]);
    }

    public function insertCart(Request $request){
        $is_exists = Cart::where([
            'user_id' => $request-> user_id,
            'product_id' => $request->product_id,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
        ])->exists();
        $cart_qty_status = "";
        if(!$is_exists){
            Cart::insert([
                'product_id' => $request-> product_id,
                'product_current_price' => $request-> product_current_price,
                'color_id' => $request-> color_id,
                'size_id' => $request-> size_id,
                'cart_qty' => $request-> cart_qty,
                'user_id' => $request-> user_id,
                'created_at' => Carbon::now(),
            ]);
            $cart_qty_status = 1;
            return response()->json([
                'status' => 200,
                'cart_qty_status' => $cart_qty_status,
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'cart_qty_status' => $cart_qty_status,
            ]);
        }
    }

    public function fetchCart(){
        $send_carts_sub_total = "00";
        if (Auth::check()) {
            $sub_total = Cart::where('user_id', Auth::user()->id)->where('status', 'Yes')->get();
            foreach($sub_total as $total){
                $send_carts_sub_total += ($total->product_current_price * $total->cart_qty);
            }
        }

        $send_carts_data = "";
        if (Auth::check()) {
            $carts = Cart::where('user_id', Auth::user()->id)->get();
            if ($carts->count() != 0) {
                foreach ($carts as $cart){
                    {{ $status  = ($cart->status == "Yes") ? "checked" : ""; }};
                    $send_carts_data .= '
                    <tr>
                        <td>
                            <span class="bg-info p-1 text-white">'.$cart->status.'</span>
                            <input type="checkbox" name="status" id="'.$cart->id.'" value="'.$cart->status.'" class="status_change" '.$status.'>
                        </td>
                        <td class="product-thumbnail">
                            <a href="'.route('product.details', $cart->relationtoproduct->product_slug).'"><img src="'.asset('uploads/product_thumbnail_photo').'/'.$cart->relationtoproduct->product_thumbnail_photo.'" alt=""></a>
                        </td>
                        <td class="product-name">
                            <a href="'.route('product.details', $cart->relationtoproduct->product_slug).'">'.$cart->relationtoproduct->product_name.'</a>
                            <br>
                            <span>Color: '.$cart->relationtocolor->color_name.'</span>
                            <br>
                            <span>Size: '.$cart->relationtosize->size_name.'</span>
                        </td>
                        <td class="product-price"><span class="amount">৳ '.$cart->product_current_price.'</span></td>
                        <td class="product-quantity">
                            <div class="cart-plus-minus">
                                <div id="'.$cart->id.'" class="dec qtybutton" onclick="decrementValue()">-</div>
                                <input type="text" name="quantity" value="'.$cart->cart_qty.'" maxlength="1" max="5" size="1" id="cart_qty" />
                                <div id="'.$cart->id.'" class="inc qtybutton" onclick="incrementValue()">+</div>
                            </div>
                        </td>
                        <td class="product-subtotal"><span class="amount">৳ '.$cart->product_current_price * $cart->cart_qty.'</span></td>
                        <td class="product-remove">
                            <button type="button" id="'.$cart->id.'" class="btn btn-danger btn-sm deleteCartBtn"><i class="fa fa-times"></i></button>
                        </td>
                    </tr>
                    ';
                }
            } else {
                $send_carts_data .='
                <tr>
                    <td colspan="50"> <span class="text-danger"> Cart Item Not Found. </span> </td>
                </tr>
                ';
            }
        }

        $grand_total = $send_carts_sub_total;
        if(Session::get('session_coupon_name')){
            $coupon = Coupon::where('coupon_name', Session::get('session_coupon_name'))->first();
            if($coupon->coupon_offer_type == 'percentage'){
                $grand_total = ($send_carts_sub_total - $coupon->coupon_offer_amount/100);
            }else{
                $grand_total = ($send_carts_sub_total - $coupon->coupon_offer_amount);
            }
        }else{
            $grand_total = $send_carts_sub_total;
        }

        return response()->json([
            'carts_data' => $send_carts_data,
            'carts_sub_total' => $send_carts_sub_total,
            'grand_total' => $grand_total,
        ]);
    }

    public function cartForceDelete($id){
        Cart::where('id', $id)->forceDelete();
    }

    public function changeCartStatus($id)
    {
        if(Cart::where('id', $id)->first()->status == "Yes"){
            Cart::where('id', $id)->update([
                'status' => "No",
            ]);
        }else{
            Cart::where('id', $id)->update([
                'status' =>"Yes",
            ]);
        }
    }

    public function cartItemInc(Request $request)
    {
        if (Cart::find($request->cart_item_id)->cart_qty != 5) {
            Cart::find($request->cart_item_id)->increment('cart_qty');
            return response()->json([
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'status' => 400,
            ]);
        }

    }
    public function cartItemDec(Request $request)
    {
        if (Cart::find($request->cart_item_id)->cart_qty != 1) {
            Cart::find($request->cart_item_id)->decrement('cart_qty');
            return response()->json([
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'status' => 400,
            ]);
        }
    }

    public function checkCoupon(Request $request){
        if ($request->coupon_name) {
            $order_Status = Cart::where('user_id', Auth::user()->id)->where('status', 'Yes')->count();
            if($order_Status > 0){
                if(Coupon::where('coupon_name', $request->coupon_name)->exists()){
                    $coupon = Coupon::where('coupon_name', $request->coupon_name)->first();
                    if(Carbon::today() <= $coupon->coupon_validity_date){
                        if($coupon->coupon_minimum_order > $request->sub_total){
                            Session::put('session_coupon_name', '');
                            return response()->json([
                                'status' => 400,
                                'error' => 'You have to order minimum '.$coupon->coupon_minimum_order
                            ]);
                        }else{
                            if($coupon->coupon_user_limit == 0){
                                Session::put('session_coupon_name', '');
                                return response()->json([
                                    'status' => 400,
                                    'error' => 'This coupon usage limit is over!'
                                ]);
                            }else{
                                Session::put('session_coupon_name', $request->coupon_name);
                                if($coupon->coupon_offer_type == 'percentage'){
                                    $grand_total = $request->sub_total - ($request->sub_total*($coupon->coupon_offer_amount/100));
                                    $coupon_offer_type = $coupon->coupon_offer_amount . " %";
                                    $coupon_offer_amount = ($request->sub_total*($coupon->coupon_offer_amount/100));
                                }else{
                                    $grand_total = $request->sub_total - $coupon->coupon_offer_amount;
                                    $coupon_offer_type = $coupon->coupon_offer_amount . " ৳";
                                    $coupon_offer_amount = $coupon->coupon_offer_amount;
                                }
                                return response()->json([
                                    'coupon_offer_type' => $coupon_offer_type,
                                    'coupon_offer_amount' => $coupon_offer_amount,
                                    'grand_total' => $grand_total,
                                    'status' => 200,
                                    'success' => 'This coupon usage successfully.'
                                ]);
                            }
                        }
                    }else{
                        Session::put('session_coupon_name', '');
                        return response()->json([
                            'status' => 400,
                            'error' => 'This coupon validity date is over!'
                        ]);
                    }
                }else{
                    Session::put('session_coupon_name', '');
                    return response()->json([
                        'status' => 400,
                        'error' => 'This coupon dose not exists!'
                    ]);
                }
            }else{
                Session::put('session_coupon_name', '');
                return response()->json([
                    'status' => 400,
                    'error' => 'Please select minimum 1 order!'
                ]);
            }
        } else {
            Session::put('session_coupon_name', '');
            return response()->json([
                'status' => 400,
                'error' => 'Please type your coupon name!'
            ]);
        }
    }

    public function removeCoupon()
    {
        if(!Session::get('session_coupon_name')){
            return response()->json([
                'status' => 400,
                'error' => 'Coupon dose not exists!'
            ]);
        }else{
            Session::forget('session_coupon_name');
            return response()->json([
                'status' => 200,
                'success' => 'This coupon remove successfully.'
            ]);
        }
    }

}
