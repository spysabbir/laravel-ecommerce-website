<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $warehouses = "";
            $query = Warehouse::select('warehouses.*');

            if($request->status){
                $query->where('warehouses.status', $request->status);
            }

            $warehouses = $query->get();

            return Datatables::of($warehouses)
            ->addIndexColumn()
            ->editColumn('status', function($row){
                if($row->status == "Yes"){
                    return'
                    <span class="badge bg-success">'.$row->status.'</span>
                    <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm warehouseStatusBtn"><i class="fa fa-ban"></i></button>
                    ';
                }else{
                    return'
                    <span class="badge bg-warning">'.$row->status.'</span>
                    <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm warehouseStatusBtn"><i class="fa fa-check"></i></button>
                    ';
                }
            })
            ->addColumn('action', function($row){
                $btn = '
                <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editWarehouseModelBtn" data-toggle="modal" data-target="#editWarehouseModel"><i class="fa fa-pencil-square-o"></i></button>
                <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteWarehouseBtn"><i class="fa fa-trash"></i></button>
                    ';
                return $btn;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
        }

        return view('admin.warehouse.index');
    }

    public function fetchTrashedWarehouse()
    {
        $send_trashed_warehouses_data = "";

        $trashed_warehouses = Warehouse::onlyTrashed()->get();

        foreach ($trashed_warehouses as $trashed_warehouse){
            $send_trashed_warehouses_data .= '
            <tr>
                <td>'.$trashed_warehouse->id.'</td>
                <td>'.$trashed_warehouse->warehouse_name.'</td>
                <td>
                    <button type="button" id="'.$trashed_warehouse->id.'" class="btn btn-success btn-sm warehouseRestoreBtn"><i class="fa fa-undo"></i></button>
                    <button type="button" id="'.$trashed_warehouse->id.'" class="btn btn-danger btn-sm warehouseForceDeleteBtn"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            ';
        }

        return response()->json([
            'trashed_warehouses' => $send_trashed_warehouses_data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'warehouse_name' => 'required|unique:warehouses',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=>$validator->errors()->toArray()
            ]);
        }else{
            Warehouse::insert([
                'warehouse_name' => $request->warehouse_name,
                'warehouse_email' => $request->warehouse_email,
                'warehouse_phone_number' => $request->warehouse_phone_number,
                'warehouse_address' => $request->warehouse_address,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Warehouse create successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $warehouse = Warehouse::where('id', $id)->first();
        return response()->json($warehouse);
    }

    public function update(Request $request, $id)
    {
        $warehouse = Warehouse::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'warehouse_name' => 'required|unique:warehouses,warehouse_name,'. $warehouse->id,
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $warehouse->update([
                'warehouse_name' => $request->warehouse_name,
                'warehouse_email' => $request->warehouse_email,
                'warehouse_phone_number' => $request->warehouse_phone_number,
                'warehouse_address' => $request->warehouse_address,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Warehouse update successfully',
            ]);
        }
    }

    public function destroy($id)
    {
        $warehouse = Warehouse::where('id', $id)->first();
        $warehouse->updated_by = Auth::guard('admin')->user()->id;
        $warehouse->deleted_by = Auth::guard('admin')->user()->id;
        $warehouse->save();
        $warehouse->delete();
        return response()->json([
            'message' => 'Warehouse destroy successfully',
        ]);
    }

    public function warehouseRestore($id)
    {
        Warehouse::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Warehouse::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Warehouse restore successfully',
        ]);
    }

    public function warehouseForceDelete($id)
    {
        Warehouse::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Warehouse force delete successfully',
        ]);
    }

    public function warehouseStatus($id){
        $warehouse = Warehouse::where('id', $id)->first();
        if($warehouse->status == "Yes"){
            $warehouse->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Warehouse status inactive',
            ]);
        }else{
            $warehouse->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Warehouse status active',
            ]);
        }
    }
}
