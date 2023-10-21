<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ChildcategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $childcategories = "";
            $query = Childcategory::leftJoin('categories', 'childcategories.category_id', 'categories.id')
                ->leftJoin('subcategories', 'childcategories.subcategory_id', 'subcategories.id');

            if($request->category_id){
                $query->where('childcategories.category_id', $request->category_id);
            }
            if($request->subcategory_id){
                $query->where('childcategories.subcategory_id', $request->subcategory_id);
            }
            if($request->status){
                $query->where('childcategories.status', $request->status);
            }

            $childcategories = $query->select('childcategories.*', 'categories.category_name', 'subcategories.subcategory_name')
            ->get();

            return Datatables::of($childcategories)
                    ->addIndexColumn()
                    ->editColumn('childcategory_photo', function($row){
                        return '<img src="'.asset('uploads/childcategory_photo').'/'.$row->childcategory_photo.'" width="40" >';
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm childcategoryStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm childcategoryStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editChildcategoryModelBtn" data-toggle="modal" data-target="#editChildcategoryModel"><i class="fa fa-pencil-square-o"></i></button>
                            <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteChildcategoryBtn"><i class="fa fa-trash"></i></button>
                            ';
                        return $btn;
                    })
                    ->rawColumns(['childcategory_photo', 'category_name', 'subcategory_name', 'status', 'action'])
                    ->make(true);
        }

        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.childcategory.index', compact('categories', 'subcategories'));
    }

    public function fetchTrashedChildcategory()
    {
        $send_trashed_childcategories_data = "";

        $trashed_childcategories = Childcategory::onlyTrashed()->get();

        foreach ($trashed_childcategories as $trashed_childcategory){
            $send_trashed_childcategories_data .= '
            <tr>
                <td>'.$trashed_childcategory->id.'</td>
                <td>'.$trashed_childcategory->childcategory_name.'</td>
                <td>
                    <button type="button" id="'.$trashed_childcategory->id.'" class="btn btn-success btn-sm childcategoryRestoreBtn"><i class="fa fa-undo"></i></button>
                    <button type="button" id="'.$trashed_childcategory->id.'" class="btn btn-danger btn-sm childcategoryForceDeleteBtn"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            ';
        }

        return response()->json([
            'trashed_childcategories' => $send_trashed_childcategories_data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'childcategory_name' => 'required',
            'childcategory_photo' => 'required|image|mimes:png,jpg,jpeg,webp',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 400,
                'error'=>$validator->errors()->toArray()
            ]);
        }else{
            $status = Childcategory::where([
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'childcategory_name' => $request->childcategory_name,
            ])->exists();

            if ($status) {
                return response()->json([
                    'status' => 401,
                ]);
            } else {
                $childcategory_slug = Str::slug($request->childcategory_name);
                // Childcategory Photo Upload
                $childcategory_photo_name =  $childcategory_slug."-childcategory-photo".".". $request->file('childcategory_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/childcategory_photo/").$childcategory_photo_name;
                Image::make($request->file('childcategory_photo'))->resize(60, 60)->save($upload_link);

                Childcategory::insert([
                    'category_id' => $request->category_id,
                    'subcategory_id' => $request->subcategory_id,
                    'childcategory_name' => $request->childcategory_name,
                    'childcategory_slug' => $childcategory_slug,
                    'childcategory_photo' => $childcategory_photo_name,
                    'created_by' => Auth::guard('admin')->user()->id,
                    'created_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Childcategory create successfully',
                ]);
            }
        }
    }

    public function edit($id)
    {
        $childcategory = Childcategory::where('id', $id)->first();
        return response()->json($childcategory);
    }

    public function update(Request $request, $id)
    {
        $childcategory = Childcategory::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'childcategory_photo' => 'nullable|image|mimes:png,jpg,jpeg,webp',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $exists = Childcategory::where([
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'childcategory_name' => $request->childcategory_name,
            ])->exists();

            $exists_id = Childcategory::where([
                'id' => $id,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'childcategory_name' => $request->childcategory_name,
            ])->exists();

            if ($exists && !$exists_id) {
                return response()->json([
                    'status' => 401,
                ]);
            } else {
                $childcategory_slug = Str::slug($request->childcategory_name);
                // Childcategory Photo Upload
                if($request->hasFile('childcategory_photo')){
                    unlink(base_path("public/uploads/childcategory_photo/").$childcategory->childcategory_photo);
                    $childcategory_photo_name =  $childcategory_slug."-childcategory-photo-".".". $request->file('childcategory_photo')->getClientOriginalExtension();
                    $upload_link = base_path("public/uploads/childcategory_photo/").$childcategory_photo_name;
                    Image::make($request->file('childcategory_photo'))->resize(60, 60)->save($upload_link);
                    $childcategory->update([
                        'childcategory_photo' => $childcategory_photo_name,
                        'updated_by' => Auth::guard('admin')->user()->id,
                    ]);
                }

                $childcategory->update([
                    'category_id' => $request->category_id,
                    'subcategory_id' => $request->subcategory_id,
                    'childcategory_name' => $request->childcategory_name,
                    'childcategory_slug' => $childcategory_slug,
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Childcategory update successfully',
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $childcategory = Childcategory::where('id', $id)->first();
        $childcategory->updated_by = Auth::guard('admin')->user()->id;
        $childcategory->deleted_by = Auth::guard('admin')->user()->id;
        $childcategory->save();
        $childcategory->delete();
        return response()->json([
            'message' => 'Childcategory destroy successfully',
        ]);
    }

    public function childcategoryRestore($id)
    {
        Childcategory::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Childcategory::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Childcategory restore successfully',
        ]);
    }

    public function childcategoryForceDelete($id)
    {
        unlink(base_path("public/uploads/childcategory_photo/").Childcategory::onlyTrashed()->where('id', $id)->first()->childcategory_photo);
        Childcategory::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Childcategory force delete successfully',
        ]);
    }

    public function childcategoryStatus($id){
        $childcategory = Childcategory::where('id', $id)->first();
        if($childcategory->status == "Yes"){
            $childcategory->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Childcategory status inactive',
            ]);
        }else{
            $childcategory->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Childcategory status active',
            ]);
        }
    }
}
