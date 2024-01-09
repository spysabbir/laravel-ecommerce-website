<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = "";
            $query = Category::select('categories.*');

            if($request->status){
                $query->where('categories.status', $request->status);
            }

            if($request->show_home_screen){
                $query->where('categories.show_home_screen', $request->show_home_screen);
            }

            $categories = $query->get();

            return Datatables::of($categories)
                    ->addIndexColumn()
                    ->editColumn('category_photo', function($row){
                        return '<img src="'.asset('uploads/category_photo').'/'.$row->category_photo.'" width="40" >';
                    })
                    ->editColumn('show_home_screen', function($row){
                        if($row->show_home_screen == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->show_home_screen.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm categoryShowHomeScreenBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->show_home_screen.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm categoryShowHomeScreenBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm categoryStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm categoryStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editCategoryModelBtn" data-toggle="modal" data-target="#editCategoryModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteCategoryBtn"><i class="fa fa-trash"></i></button>
                            ';
                        return $btn;
                    })
                    ->rawColumns(['category_photo', 'show_home_screen', 'status', 'action'])
                    ->make(true);
        }

        return view('admin.category.index');
    }

    public function fetchTrashedCategory()
    {
        $send_trashed_categories_data = "";

        $trashed_categories = Category::onlyTrashed()->get();

        foreach ($trashed_categories as $trashed_category){
            $send_trashed_categories_data .= '
            <tr>
                <td>'.$trashed_category->id.'</td>
                <td>'.$trashed_category->category_name.'</td>
                <td>
                    <button type="button" id="'.$trashed_category->id.'" class="btn btn-success btn-sm categoryRestoreBtn"><i class="fa fa-undo"></i></button>
                    <button type="button" id="'.$trashed_category->id.'" class="btn btn-danger btn-sm categoryForceDeleteBtn"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            ';
        }

        return response()->json([
            'trashed_categories' => $send_trashed_categories_data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:categories',
            'category_photo' => 'required|image|mimes:png,jpg,jpeg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $category_slug = Str::slug($request->category_name);

            // Category Photo Upload
            $category_photo_name =  $category_slug."-category-photo".".". $request->file('category_photo')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/category_photo/").$category_photo_name;
            Image::make($request->file('category_photo'))->resize(272, 140)->save($upload_link);

            Category::insert([
                'category_name' => $request->category_name,
                'category_slug' => $category_slug,
                'category_photo' => $category_photo_name,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Category update successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $category = Category::where('id', $id)->first();
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:categories,category_name,'. $category->id,
            'category_photo' => 'nullable|image|mimes:png,jpg,jpeg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $category_slug = Str::slug($request->category_name);
            // Category Photo Upload
            if($request->hasFile('category_photo')){
                unlink(base_path("public/uploads/category_photo/").$category->category_photo);
                $category_photo_name =  $category_slug."-category-photo".".". $request->file('category_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/category_photo/").$category_photo_name;
                Image::make($request->file('category_photo'))->resize(272, 140)->save($upload_link);
                $category->update([
                    'category_photo' => $category_photo_name,
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);
            }

            $category->update([
                'category_name' => $request->category_name,
                'category_slug' => $category_slug,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Category update successfully',
            ]);
        }
    }

    public function destroy($id)
    {
        $category = Category::where('id', $id)->first();
        $category->updated_by = Auth::guard('admin')->user()->id;
        $category->deleted_by = Auth::guard('admin')->user()->id;
        $category->save();
        $category->delete();
        return response()->json([
            'message' => 'Category destroy successfully',
        ]);
    }

    public function categoryRestore($id)
    {
        Category::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Category::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Category restore successfully',
        ]);
    }

    public function categoryForceDelete($id)
    {
        unlink(base_path("public/uploads/category_photo/").Category::onlyTrashed()->where('id', $id)->first()->category_photo);
        Category::onlyTrashed()->where('id', $id)->forceDelete();
        Subcategory::where('category_id', $id)->forceDelete();
        return response()->json([
            'message' => 'Category force delete successfully',
        ]);
    }

    public function categoryStatus($id){
        $category = Category::where('id', $id)->first();
        if($category->status == "Yes"){
            $category->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Category status inactive',
            ]);
        }else{
            $category->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Category status active',
            ]);
        }
    }

    public function categoryShowHomeScreen($id){
        $category = Category::where('id', $id)->first();
        if($category->show_home_screen == "Yes"){
            $category->update([
                'show_home_screen' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
        }else{
            $category->update([
                'show_home_screen' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
        }
    }
}
