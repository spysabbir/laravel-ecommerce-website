<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ColorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $colors = "";
            $query = Color::select('colors.*');

            if($request->status){
                $query->where('colors.status', $request->status);
            }

            $colors = $query->get();

            return Datatables::of($colors)
                    ->addIndexColumn()
                    ->editColumn('color_code', function($row){
                        return'
                        <span class="p-1" style="background-color:'.$row->color_code.'"> '.$row->color_name.' </span>
                        ';
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm colorStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm colorStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editColorModelBtn" data-toggle="modal" data-target="#editColorModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteColorBtn"><i class="fa fa-trash"></i></button>
                            ';
                        return $btn;
                    })
                    ->rawColumns(['status', 'color_code', 'action'])
                    ->make(true);
        }
        return view('admin.color.index');
    }

    public function fetchTrashedColor()
    {
        $send_trashed_colors_data = "";

        $trashed_colors = Color::onlyTrashed()->get();

        foreach ($trashed_colors as $trashed_color){
            $send_trashed_colors_data .= '
            <tr>
                <td>'.$trashed_color->id.'</td>
                <td>'.$trashed_color->color_name.'</td>
                <td><span class="p-1" style="background-color:'.$trashed_color->color_code.'"> '.$trashed_color->color_name.' </span></td>
                <td>
                    <button type="button" id="'.$trashed_color->id.'" class="btn btn-success btn-sm colorRestoreBtn"><i class="fa fa-undo"></i></button>
                    <button type="button" id="'.$trashed_color->id.'" class="btn btn-danger btn-sm colorForceDeleteBtn"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            ';
        }

        return response()->json([
            'trashed_colors' => $send_trashed_colors_data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'color_name' => 'required|unique:colors',
            'color_code' => 'required|unique:colors',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            Color::insert([
                'color_name' => $request->color_name,
                'color_code' => $request->color_code,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Color create successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $color = Color::where('id', $id)->first();
        return response()->json($color);
    }

    public function update(Request $request, $id)
    {
        $color = Color::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            'color_name' => 'required|unique:colors,color_name,'.$color->id,
            'color_code' => 'required|unique:colors,color_code,'.$color->id,
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $color->update([
                'color_name' => $request->color_name,
                'color_code' => $request->color_code,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Color update successfully',
            ]);
        }
    }

    public function destroy($id)
    {
        $color = Color::where('id', $id)->first();
        $color->updated_by = Auth::guard('admin')->user()->id;
        $color->deleted_by = Auth::guard('admin')->user()->id;
        $color->save();
        $color->delete();
        return response()->json([
            'message' => 'Color destroy successfully',
        ]);
    }

    public function colorRestore($id)
    {
        Color::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Color::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Color restore successfully',
        ]);
    }

    public function colorForceDelete($id)
    {
        Color::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Color force delete successfully',
        ]);
    }

    public function colorStatus($id){
        $color = Color::where('id', $id)->first();
        if($color->status == "Yes"){
            $color->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Color status inactive',
            ]);
        }else{
            $color->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Color status active',
            ]);
        }
    }
}
