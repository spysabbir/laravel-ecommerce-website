<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $subcategories = "";
            $query = Subcategory::leftJoin('categories', 'subcategories.category_id', 'categories.id');

            if($request->category_id){
                $query->where('subcategories.category_id', $request->category_id);
            }

            if($request->status){
                $query->where('subcategories.status', $request->status);
            }

            $subcategories = $query->select('subcategories.*', 'categories.category_name')
            ->get();

            return DataTables::of($subcategories)
                    ->addIndexColumn()
                    ->editColumn('subcategory_photo', function($row){
                        return '<img src="'.asset('uploads/subcategory_photo').'/'.$row->subcategory_photo.'" width="40" >';
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm subcategoryStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm subcategoryStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editSubcategoryModelBtn" data-toggle="modal" data-target="#editSubcategoryModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteSubcategoryBtn"><i class="fa fa-trash"></i></button>
                            ';
                        return $btn;
                    })
                    ->rawColumns(['subcategory_photo', 'category_name', 'status', 'action'])
                    ->make(true);
        }

        $categories = Category::all();
        return view('admin.subcategory.index', compact('categories'));
    }

    public function fetchTrashedSubcategory()
    {
        $send_trashed_subcategories_data = "";

        $trashed_subcategories = Subcategory::onlyTrashed()->get();

        foreach ($trashed_subcategories as $trashed_subcategory){
            $send_trashed_subcategories_data .= '
            <tr>
                <td>'.$trashed_subcategory->id.'</td>
                <td>'.$trashed_subcategory->subcategory_name.'</td>
                <td>
                    <button type="button" id="'.$trashed_subcategory->id.'" class="btn btn-success btn-sm subcategoryRestoreBtn"><i class="fa fa-undo"></i></button>
                    <button type="button" id="'.$trashed_subcategory->id.'" class="btn btn-danger btn-sm subcategoryForceDeleteBtn"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            ';
        }

        return response()->json([
            'trashed_subcategories' => $send_trashed_subcategories_data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'subcategory_photo' => 'required|image|mimes:png,jpg,jpeg,webp',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $status = Subcategory::where([
                'category_id' => $request->category_id,
                'subcategory_name' => $request->subcategory_name,
            ])->exists();

            if ($status) {
                return response()->json([
                    'status' => 401,
                ]);
            } else {
                $subcategory_slug = Str::slug($request->subcategory_name);

                // Subcategory Photo Upload
                $subcategory_photo_name =  $subcategory_slug."-subcategory-photo".".". $request->file('subcategory_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/subcategory_photo/").$subcategory_photo_name;
                Image::make($request->file('subcategory_photo'))->resize(60, 60)->save($upload_link);

                Subcategory::insert([
                    'category_id' => $request->category_id,
                    'subcategory_name' => $request->subcategory_name,
                    'subcategory_slug' => $subcategory_slug,
                    'subcategory_photo' => $subcategory_photo_name,
                    'created_by' => Auth::guard('admin')->user()->id,
                    'created_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Subcategory create successfully',
                ]);
            }

        }
    }

    public function edit($id)
    {
        $subcategory = Subcategory::where('id', $id)->first();
        return response()->json($subcategory);
    }

    public function update(Request $request, $id)
    {
        $subcategory = Subcategory::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'subcategory_photo' => 'nullable|image|mimes:png,jpg,jpeg,webp',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $exists = Subcategory::where([
                'category_id' => $request->category_id,
                'subcategory_name' => $request->subcategory_name,
            ])->exists();

            $exists_id = Subcategory::where([
                'id' => $id,
                'category_id' => $request->category_id,
                'subcategory_name' => $request->subcategory_name,
            ])->exists();

            if ($exists && !$exists_id) {
                return response()->json([
                    'status' => 401,
                ]);
            } else {
                $subcategory_slug = Str::slug($request->subcategory_name);
                // Subcategory Photo Upload
                if($request->hasFile('subcategory_photo')){
                    unlink(base_path("public/uploads/subcategory_photo/").$subcategory->subcategory_photo);
                    $subcategory_photo_name =  $subcategory_slug."-subcategory-photo-".".". $request->file('subcategory_photo')->getClientOriginalExtension();
                    $upload_link = base_path("public/uploads/subcategory_photo/").$subcategory_photo_name;
                    Image::make($request->file('subcategory_photo'))->resize(60, 60)->save($upload_link);
                    $subcategory->update([
                        'subcategory_photo' => $subcategory_photo_name,
                        'updated_by' => Auth::guard('admin')->user()->id,
                    ]);
                }

                $subcategory->update([
                    'category_id' => $request->category_id,
                    'subcategory_name' => $request->subcategory_name,
                    'subcategory_slug' => $subcategory_slug,
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Subcategory update successfully',
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $subcategory = Subcategory::where('id', $id)->first();
        $subcategory->updated_by = Auth::guard('admin')->user()->id;
        $subcategory->deleted_by = Auth::guard('admin')->user()->id;
        $subcategory->save();
        $subcategory->delete();
        return response()->json([
            'message' => 'Subcategory destroy successfully',
        ]);
    }

    public function subcategoryRestore($id)
    {
        Subcategory::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Subcategory::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Subcategory restore successfully',
        ]);
    }

    public function subcategoryForceDelete($id)
    {
        unlink(base_path("public/uploads/subcategory_photo/").Subcategory::onlyTrashed()->where('id', $id)->first()->subcategory_photo);
        Subcategory::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Subcategory force delete successfully',
        ]);
    }

    public function subcategoryStatus($id){
        $subcategory = Subcategory::where('id', $id)->first();
        if($subcategory->status == "Yes"){
            $subcategory->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
            'message' => 'Subcategory status inactive',
        ]);
        }else{
            $subcategory->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
            'message' => 'Subcategory status active',
        ]);
        }
    }
}
