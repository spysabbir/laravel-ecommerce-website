<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AdministrationController extends Controller
{
    public function allAdministration(Request $request){
        if ($request->ajax()) {
            $administrations = "";
            $query = Admin::select('admins.*');

            if($request->status){
                $query->where('admins.status', $request->status);
            }

            if($request->role){
                $query->where('admins.role', $request->role);
            }

            $administrations = $query->get();

            return Datatables::of($administrations)
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
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm administrationStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm administrationStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->editColumn('role', function($row){
                        if($row->role == "Super Admin"){
                            return'
                            <span class="badge bg-success">'.$row->role.'</span>
                            ';
                        }else{
                            if($row->role == "Admin"){
                                return'
                                <span class="badge bg-info">'.$row->role.'</span>
                                ';
                            }else{
                                if($row->warehouse_id){
                                    return'
                                    <span class="badge bg-primary">'.$row->role.'</span>
                                    <span class="badge bg-light">'.$row->relationtowarehouse->warehouse_name.'</span>
                                    ';
                                }else{
                                    return'
                                    <span class="badge bg-primary">'.$row->role.'</span>
                                    ';
                                }
                            }
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-info btn-sm editAdministrationModelBtn" data-toggle="modal" data-target="#editAdministrationModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm viewAdministrationModelBtn" data-toggle="modal" data-target="#viewAdministrationModel"><i class="fa fa-eye"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['profile_photo', 'created_at', 'status', 'role', 'action'])
                    ->make(true);
        }

        $warehouses = Warehouse::where('status', 'Yes')->get();
        return view('admin.administration.index', compact('warehouses'));
    }

    public function administrationDetails($id)
    {
        $administration_details = Admin::where('id', $id)->first();
        return view('admin.administration.details', compact('administration_details'));
    }

    public function administrationEdit($id)
    {
        $administration = Admin::where('id', $id)->first();
        return response()->json($administration);
    }

    public function administrationUpdate(Request $request, $id)
    {
        $administration = Admin::where('id', $id)->first();
        $validator = Validator::make($request->all(), [
            'role' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            if($request->role == 'Manager' && $request->warehouse_id == NULL){
                return response()->json([
                    'status' => 401,
                    'message' => 'Please select warehouse name.',
                ]);
            }
            $administration->update([
                'role' => $request->role,
                'warehouse_id' => $request->warehouse_id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Administration updated successfully',
            ]);
        }
    }

    public function administrationStatus($id){
        if(Admin::where('id', $id)->first()->status == "Yes"){
            Admin::where('id', $id)->update([
                'status' => "No",
            ]);
            return response()->json([
                'message' => 'Administration status inactive successfully',
            ]);
        }else{
            Admin::where('id', $id)->update([
                'status' =>"Yes",
            ]);
            return response()->json([
                'message' => 'Administration status active successfully',
            ]);
        }
    }
}
