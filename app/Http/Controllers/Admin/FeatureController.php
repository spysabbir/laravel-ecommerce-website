<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class FeatureController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $features = "";
            $query = Feature::select('features.*');

            if($request->status){
                $query->where('features.status', $request->status);
            }

            $features = $query->get();

            return Datatables::of($features)
                    ->addIndexColumn()
                    ->editColumn('feature_photo', function($row){
                        return '<img src="'.asset('uploads/feature_photo').'/'.$row->feature_photo.'" width="40" >';
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm featureStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm featureStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editFeatureModelBtn" data-toggle="modal" data-target="#editFeatureModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteFeatureBtn"><i class="fa fa-trash"></i></button>
                            ';
                        return $btn;
                    })
                    ->rawColumns(['feature_photo', 'status', 'action'])
                    ->make(true);
        }
        return view('admin.feature.index');
    }

    public function fetchTrashedFeature()
    {
        $send_trashed_features_data = "";

        $trashed_features = Feature::onlyTrashed()->get();

        foreach ($trashed_features as $trashed_feature){
            $send_trashed_features_data .= '
            <tr>
                <td>'.$trashed_feature->id.'</td>
                <td>'.$trashed_feature->feature_title.'</td>
                <td>
                    <button type="button" id="'.$trashed_feature->id.'" class="btn btn-success btn-sm featureRestoreBtn"><i class="fa fa-undo"></i></button>
                    <button type="button" id="'.$trashed_feature->id.'" class="btn btn-danger btn-sm featureForceDeleteBtn"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            ';
        }

        return response()->json([
            'trashed_features' => $send_trashed_features_data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'feature_title' => 'required|unique:features',
            'feature_photo' => 'required|image|mimes:png,jpg,jpeg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            // Feature Photo Upload
            $feature_photo_name =  Str::slug($request->feature_title).".". $request->file('feature_photo')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/feature_photo/").$feature_photo_name;
            Image::make($request->file('feature_photo'))->resize(50, 40)->save($upload_link);

            Feature::insert([
                'feature_title' => $request->feature_title,
                'feature_subtitle' => $request->feature_subtitle,
                'feature_photo' => $feature_photo_name,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Feature create successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $feature = Feature::where('id', $id)->first();
        return response()->json($feature);
    }

    public function update(Request $request, $id)
    {
        $feature = Feature::where('id', $id)->first();
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'feature_title' => 'required|unique:features,feature_title,'. $feature->id,
            'feature_photo' => 'nullable|image|mimes:png,jpg,jpeg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            // Feature Photo Upload
            if($request->hasFile('feature_photo')){
                unlink(base_path("public/uploads/feature_photo/").$feature->feature_photo);
                $feature_photo_name =  $feature->id."-Feature-Photo".".". $request->file('feature_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/feature_photo/").$feature_photo_name;
                Image::make($request->file('feature_photo'))->resize(50, 40)->save($upload_link);
                $feature->update([
                    'feature_photo' => $feature_photo_name,
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);
            }

            $feature->update([
                'feature_title' => $request->feature_title,
                'feature_subtitle' => $request->feature_subtitle,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Feature update successfully',
            ]);
        }
    }

    public function destroy($id)
    {
        $feature = Feature::where('id', $id)->first();
        $feature->updated_by = Auth::guard('admin')->user()->id;
        $feature->deleted_by = Auth::guard('admin')->user()->id;
        $feature->save();
        $feature->delete();
        return response()->json([
            'message' => 'Feature destroy successfully',
        ]);
    }

    public function featureRestore($id)
    {
        Feature::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Feature::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Feature restore successfully',
        ]);
    }

    public function featureForceDelete($id)
    {
        unlink(base_path("public/uploads/feature_photo/").Feature::onlyTrashed()->where('id', $id)->first()->feature_photo);
        Feature::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Feature force delete successfully',
        ]);
    }

    public function featureStatus($id){
        $feature = Feature::where('id', $id)->first();
        if($feature->status == "Yes"){
            $feature->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
            'message' => 'Feature status inactive',
        ]);
        }else{
            $feature->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
            'message' => 'Feature status active',
        ]);
        }
    }
}
