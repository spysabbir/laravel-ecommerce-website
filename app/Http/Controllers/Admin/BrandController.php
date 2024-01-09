<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $brands = "";
            $query = Brand::select('brands.*');

            if($request->status){
                $query->where('brands.status', $request->status);
            }

            $brands = $query->get();

            return Datatables::of($brands)
                    ->addIndexColumn()
                    ->editColumn('brand_photo', function($row){
                        return '<img src="'.asset('uploads/brand_photo').'/'.$row->brand_photo.'" width="40" >';
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm brandStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm brandStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editBrandModelBtn" data-toggle="modal" data-target="#editBrandModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteBrandBtn"><i class="fa fa-trash"></i></button>
                            ';
                        return $btn;
                    })
                    ->rawColumns(['brand_photo', 'status', 'action'])
                    ->make(true);
        }

        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.brand.index', compact('categories', 'subcategories'));
    }

    public function fetchTrashedBrand()
    {
        $send_trashed_brands_data = "";

        $trashed_brands = Brand::onlyTrashed()->get();

        foreach ($trashed_brands as $trashed_brand){
            $send_trashed_brands_data .= '
            <tr>
                <td>'.$trashed_brand->id.'</td>
                <td>'.$trashed_brand->brand_name.'</td>
                <td>
                    <button type="button" id="'.$trashed_brand->id.'" class="btn btn-success btn-sm brandRestoreBtn"><i class="fa fa-undo"></i></button>
                    <button type="button" id="'.$trashed_brand->id.'" class="btn btn-danger btn-sm brandForceDeleteBtn"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            ';
        }

        return response()->json([
            'trashed_brands' => $send_trashed_brands_data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required|unique:brands',
            'brand_photo' => 'required|image|mimes:png,jpg,jpeg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $brand_slug = Str::slug($request->brand_name);

            // Brand Photo Upload
            $brand_photo_name =  $brand_slug."-brand-photo".".". $request->file('brand_photo')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/brand_photo/").$brand_photo_name;
            Image::make($request->file('brand_photo'))->resize(210, 50)->save($upload_link);

            Brand::insert([
                'brand_name' => $request->brand_name,
                'brand_slug' => $brand_slug,
                'brand_photo' => $brand_photo_name,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Brand create successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $brand = Brand::where('id', $id)->first();
        return response()->json($brand);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            'brand_name' => 'required|unique:brands,brand_name,'.$brand->id,
            'brand_photo' => 'nullable|image|mimes:png,jpg,jpeg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $brand_slug = Str::slug($request->brand_name);
            // Brand Photo Upload
            if($request->hasFile('brand_photo')){
                unlink(base_path("public/uploads/brand_photo/").$brand->brand_photo);
                $brand_photo_name =  $brand->id."-brand-photo".".". $request->file('brand_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/brand_photo/").$brand_photo_name;
                Image::make($request->file('brand_photo'))->resize(210, 50)->save($upload_link);
                $brand->update([
                    'brand_photo' => $brand_photo_name,
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);
            }

            $brand->update([
                'brand_name' => $request->brand_name,
                'brand_slug' => $brand_slug,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Brand update successfully',
            ]);
        }
    }

    public function destroy($id)
    {
        $brand = Brand::where('id', $id)->first();
        $brand->updated_by = Auth::guard('admin')->user()->id;
        $brand->deleted_by = Auth::guard('admin')->user()->id;
        $brand->save();
        $brand->delete();
        return response()->json([
            'message' => 'Brand destroy successfully',
        ]);
    }

    public function brandRestore($id)
    {
        Brand::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Brand::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Brand restore successfully',
        ]);
    }

    public function brandForceDelete($id)
    {
        unlink(base_path("public/uploads/brand_photo/").Brand::onlyTrashed()->where('id', $id)->first()->brand_photo);
        Brand::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Brand force delete successfully',
        ]);
    }

    public function brandStatus($id){
        $brand = Brand::where('id', $id)->first();
        if($brand->status == "Yes"){
            $brand->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Brand status inactive',
            ]);
        }else{
            $brand->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Brand status active',
            ]);
        }
    }
}
