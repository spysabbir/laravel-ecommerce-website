<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function allStaff(Request $request){
        if ($request->ajax()) {
            $staffs = "";
            $query = Admin::where('role', 'Manager')->select('admins.*');

            if($request->status){
                $query->where('admins.status', $request->status);
            }

            $staffs = $query->get();

            return Datatables::of($staffs)
                    ->addIndexColumn()
                    ->editColumn('profile_photo', function($row){
                        return '<img src="'.asset('uploads/profile_photo').'/'.$row->profile_photo.'" width="40" >';
                    })
                    ->editColumn('created_at', function($row){
                            return'
                            <span class="badge badge-info">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
                            ';
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm staffStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm staffStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->editColumn('warehouse_name', function($row){
                        return'
                        <span class="badge bg-success">'.$row->relationtowarehouse->warehouse_name.'</span>
                        ';
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-info btn-sm editStaffModelBtn" data-toggle="modal" data-target="#editStaffModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm viewStaffModelBtn" data-toggle="modal" data-target="#viewStaffModel"><i class="fa fa-eye"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['profile_photo', 'created_at', 'status', 'warehouse_name', 'action'])
                    ->make(true);
        }

        $warehouses = Warehouse::where('status', 'Yes')->get();
        return view('admin.staff.index', compact('warehouses'));
    }

    public function staffDetails($id)
    {
        $staff_details = Admin::where('id', $id)->first();
        return view('admin.staff.details', compact('staff_details'));
    }

    public function staffEdit($id)
    {
        $staff = Admin::where('id', $id)->first();
        return response()->json($staff);
    }

    public function staffUpdate(Request $request, $id)
    {
        $staff = Admin::where('id', $id)->first();
        $validator = Validator::make($request->all(), [
            'warehouse_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $staff->update([
                'warehouse_id' => $request->warehouse_id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Staff updated successfully',
            ]);
        }
    }

    public function staffStatus($id){
        if(Admin::where('id', $id)->first()->status == "Yes"){
            Admin::where('id', $id)->update([
                'status' => "No",
            ]);
            return response()->json([
                'message' => 'Staff status inactive successfully',
            ]);
        }else{
            Admin::where('id', $id)->update([
                'status' =>"Yes",
            ]);
            return response()->json([
                'message' => 'Staff status active successfully',
            ]);
        }
    }
}
