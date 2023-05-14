<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Shipping;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class ShippingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $shippings = "";
            $query = Shipping::leftJoin('countries', 'shippings.country_id', 'countries.id');

            if($request->country_id){
                $query->where('shippings.country_id', $request->country_id);
            }

            if($request->status){
                $query->where('shippings.status', $request->status);
            }

            $shippings = $query->select('shippings.*', 'countries.country_name')
            ->get();

            return Datatables::of($shippings)
                    ->addIndexColumn()
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm shippingStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm shippingStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editShippingModelBtn" data-toggle="modal" data-target="#editShippingModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteShippingBtn"><i class="fa fa-trash"></i></button>
                            ';
                        return $btn;
                    })
                    ->rawColumns(['country_name', 'status', 'action'])
                    ->make(true);
        }
        $countries = Country::all();
        return view('admin.shipping.index', compact('countries'));
    }

    public function fetchTrashedShipping()
    {
        $send_trashed_shippings_data = "";

        $trashed_shippings = Shipping::onlyTrashed()->get();

        foreach ($trashed_shippings as $trashed_shipping){
            $send_trashed_shippings_data .= '
            <tr>
                <td>'.$trashed_shipping->id.'</td>
                <td>'.$trashed_shipping->country_id.'</td>
                <td>'.$trashed_shipping->city_name.'</td>
                <td>
                    <button type="button" id="'.$trashed_shipping->id.'" class="btn btn-success btn-sm shippingRestoreBtn"><i class="fa fa-undo"></i></button>
                    <button type="button" id="'.$trashed_shipping->id.'" class="btn btn-danger btn-sm shippingForceDeleteBtn"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            ';
        }

        return response()->json([
            'trashed_shippings' => $send_trashed_shippings_data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $status = Shipping::where([
                'country_id' => $request->country_id,
                'city_name' => $request->city_name,
            ])->exists();

            if($status){
                return response()->json([
                    'status' => 401,
                    'error' => 'This country & city already exists.',
                ]);
            }else{
                Shipping::insert($request->except('_token')+['created_at' => Carbon::now(), 'created_by' => Auth::guard('admin')->user()->id]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Shipping create successfully',
                ]);
            }
        }
    }

    public function edit($id)
    {
        $shipping = Shipping::where('id', $id)->first();
        return response()->json($shipping);
    }

    public function update(Request $request, $id)
    {
        $shipping = Shipping::where('id', $id)->first();
        $validator = Validator::make($request->all(), [
            '*' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $exists = Shipping::where([
                'country_id' => $request->country_id,
                'city_name' => $request->city_name,
            ])->exists();

            if($exists){
                return response()->json([
                    'status' => 401,
                    'error' => 'This country & city already exists.',
                ]);
            }else{
                $shipping->update([
                    'country_id' => $request->country_id,
                    'city_name' => $request->city_name,
                    'shipping_charge' => $request->shipping_charge,
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Shipping update successfully',
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $shipping = Shipping::where('id', $id)->first();
        $shipping->updated_by = Auth::guard('admin')->user()->id;
        $shipping->deleted_by = Auth::guard('admin')->user()->id;
        $shipping->save();
        $shipping->delete();
        return response()->json([
            'message' => 'Shipping destroy successfully',
        ]);
    }

    public function shippingRestore($id)
    {
        Shipping::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Shipping::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Shipping restore successfully',
        ]);
    }

    public function shippingForceDelete($id)
    {
        Shipping::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Shipping force delete successfully',
        ]);
    }

    public function shippingStatus($id){
        $shipping = Shipping::where('id', $id)->first();
        if($shipping->status == "Yes"){
            $shipping->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
            'message' => 'Shipping status inactive',
            ]);
        }else{
            $shipping->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
            'message' => 'Shipping status active',
            ]);
        }
    }
}
