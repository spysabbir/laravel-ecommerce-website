<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product_inventory;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function wishlist()
    {
        return view('frontend.wishlist');
    }

    public function insertWishlist(Request $request){
        $is_exists = Wishlist::where([
            'product_id' => $request-> product_id,
            'user_id' => $request-> user_id,
        ])->exists();
        $wishlist_qty_status = "";
        if(!$is_exists){
            Wishlist::insert([
                'product_id' => $request-> product_id,
                'user_id' => $request-> user_id,
                'created_at' => Carbon::now(),
            ]);
            $wishlist_qty_status = 1;
            return response()->json([
                'status' => 200,
                'wishlist_qty_status' => $wishlist_qty_status,
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'wishlist_qty_status' => $wishlist_qty_status,
            ]);
        }
    }

    public function fetchWishlist(){
        $send_wishlists_data = "";
        $wishlists = Wishlist::where('user_id', Auth::user()->id)->get();

        if ($wishlists->count() != 0) {
            foreach ($wishlists as $wishlist){
                $send_wishlists_data .= '
                <tr>
                    <td class="product-thumbnail">
                        <a href=""><img width="75" height="75" src="'.asset('uploads/product_thumbnail_photo').'/'.$wishlist->relationtoproduct->product_thumbnail_photo.'" alt=""></a>
                    </td>
                    <td class="product-name">
                        <a href="">'.$wishlist->relationtoproduct->product_name.'</a>
                    </td>
                    <td class="product-price"><span class="amount">'.$wishlist->relationtoproduct->discounted_price.'</span></td>
                    <td class="product-quantity">
                        <span>'.Product_inventory::where('product_id', $wishlist->relationtoproduct->id)->sum('quantity').'</span>
                    </td>
                    <td class="product-remove">
                        <button type="button" id="'.$wishlist->relationtoproduct->id.'" data-bs-toggle="modal"
                        data-bs-target="#quickViewProductModal" class="btn btn-info btn-sm quickViewProductBtn"> <i class="fal fa-eye"></i> </button>
                        <button type="button" id="'.$wishlist->id.'" class="btn btn-danger btn-sm deleteWishlistBtn"><i class="fa fa-times"></i></button>
                    </td>
                </tr>
                ';
            }
        } else {
            $send_wishlists_data .='
           <tr>
            <td colspan="50"> <span class="text-danger"> Wishlist Item Not Found. </span> </td>
           </tr>
           ';
        }
        return response()->json([
            'wishlists' => $send_wishlists_data,
        ]);
    }

    public function wishlistForceDelete($id){
        Wishlist::where('id', $id)->forceDelete();

        $send_header_wishlist_num = Wishlist::where('user_id', Auth::user()->id)->count();

        return response()->json([
            'header_wishlist_num' => $send_header_wishlist_num,
        ]);
    }
}
