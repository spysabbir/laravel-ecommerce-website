<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $coupons = "";
            $query = Coupon::select('coupons.*');

            if($request->status){
                $query->where('coupons.status', $request->status);
            }

            $coupons = $query->get();

            return Datatables::of($coupons)
                    ->addIndexColumn()
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm couponStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm couponStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editCouponModelBtn" data-toggle="modal" data-target="#editCouponModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteCouponBtn"><i class="fa fa-trash"></i></button>
                            ';
                        return $btn;
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
        }
        return view('admin.coupon.index');
    }

    public function fetchTrashedCoupon()
    {
        $send_trashed_coupons_data = "";

        $trashed_coupons = Coupon::onlyTrashed()->get();

        foreach ($trashed_coupons as $trashed_coupon){
            $send_trashed_coupons_data .= '
            <tr>
                <td>'.$trashed_coupon->id.'</td>
                <td>'.$trashed_coupon->coupon_name.'</td>
                <td>
                    <button type="button" id="'.$trashed_coupon->id.'" class="btn btn-success btn-sm couponRestoreBtn"><i class="fa fa-undo"></i></button>
                    <button type="button" id="'.$trashed_coupon->id.'" class="btn btn-danger btn-sm couponForceDeleteBtn"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            ';
        }

        return response()->json([
            'trashed_coupons' => $send_trashed_coupons_data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'coupon_name' => 'required|unique:coupons',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=>$validator->errors()->toArray()
            ]);
        }else{
            Coupon::insert([
                'coupon_name' => $request->coupon_name,
                'coupon_offer_type' => $request->coupon_offer_type,
                'coupon_offer_amount' => $request->coupon_offer_amount,
                'coupon_minimum_order' => $request->coupon_minimum_order,
                'coupon_validity_date' => $request->coupon_validity_date,
                'coupon_user_limit' => $request->coupon_user_limit,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Coupon update successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $coupon = Coupon::where('id', $id)->first();
        return response()->json($coupon);
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'coupon_name' => 'required|unique:coupons,coupon_name,'. $coupon->id,
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $coupon->update([
                'coupon_name' => $request->coupon_name,
                'coupon_offer_type' => $request->coupon_offer_type,
                'coupon_offer_amount' => $request->coupon_offer_amount,
                'coupon_minimum_order' => $request->coupon_minimum_order,
                'coupon_validity_date' => $request->coupon_validity_date,
                'coupon_user_limit' => $request->coupon_user_limit,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Coupon update successfully',
            ]);
        }
    }

    public function destroy($id)
    {
        $coupon = Coupon::where('id', $id)->first();
        $coupon->updated_by = Auth::guard('admin')->user()->id;
        $coupon->deleted_by = Auth::guard('admin')->user()->id;
        $coupon->save();
        $coupon->delete();
        return response()->json([
            'message' => 'Coupon destroy successfully',
        ]);
    }

    public function couponRestore($id)
    {
        Coupon::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Coupon::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Coupon restore successfully',
        ]);
    }

    public function couponForceDelete($id)
    {
        Coupon::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Coupon force delete successfully',
        ]);
    }

    public function couponStatus($id){
        $coupon = Coupon::where('id', $id)->first();
        if($coupon->status == "Yes"){
            $coupon->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Coupon status inactive',
            ]);
        }else{
            $coupon->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Coupon status active',
            ]);
        }
    }
}
