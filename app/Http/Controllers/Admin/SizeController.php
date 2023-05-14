<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class SizeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sizes = "";
            $query = Size::select('sizes.*');

            if($request->status){
                $query->where('sizes.status', $request->status);
            }

            $sizes = $query->get();

            return Datatables::of($sizes)
                    ->addIndexColumn()
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm sizeStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm sizeStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editSizeModelBtn" data-toggle="modal" data-target="#editSizeModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteSizeBtn"><i class="fa fa-trash"></i></button>
                            ';
                        return $btn;
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
        }
        return view('admin.size.index');
    }

    public function fetchTrashedSize()
    {
        $send_trashed_sizes_data = "";
        $trashed_sizes = Size::onlyTrashed()->get();
        foreach ($trashed_sizes as $trashed_size){
            $send_trashed_sizes_data .= '
            <tr>
                <td>'.$trashed_size->id.'</td>
                <td>'.$trashed_size->size_name.'</td>
                <td>
                    <button type="button" id="'.$trashed_size->id.'" class="btn btn-success btn-sm sizeRestoreBtn"><i class="fa fa-undo"></i></button>
                    <button type="button" id="'.$trashed_size->id.'" class="btn btn-danger btn-sm sizeForceDeleteBtn"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            ';
        }
        return response()->json([
            'trashed_sizes' => $send_trashed_sizes_data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'size_name' => 'required|unique:sizes',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            Size::insert([
                'size_name' => $request->size_name,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Size create successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $size = Size::where('id', $id)->first();
        return response()->json($size);
    }

    public function update(Request $request, $id)
    {
        $size = Size::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            'size_name' => 'required|unique:sizes,size_name,'.$size->id,
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $size->update([
                'size_name' => $request->size_name,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Size update successfully',
            ]);
        }
    }

    public function destroy($id)
    {
        $size = Size::where('id', $id)->first();
        $size->updated_by = Auth::guard('admin')->user()->id;
        $size->deleted_by = Auth::guard('admin')->user()->id;
        $size->save();
        $size->delete();
        return response()->json([
            'message' => 'Size destroy successfully',
        ]);
    }

    public function sizeRestore($id)
    {
        Size::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Size::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Size restore successfully',
        ]);
    }

    public function sizeForceDelete($id)
    {
        Size::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Size force delete successfully',
        ]);
    }

    public function sizeStatus($id){
        $size = Size::where('id', $id)->first();
        if($size->status == "Yes"){
            $size->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Size status inactive',
            ]);
        }else{
            $size->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Size status active',
            ]);
        }
    }
}
