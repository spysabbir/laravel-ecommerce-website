<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog_category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class Blog_categoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $blog_categories = Blog_category::all();

            return Datatables::of($blog_categories)
            ->addIndexColumn()
            ->editColumn('status', function($row){
                if($row->status == "Yes"){
                    return'
                    <span class="badge bg-success">'.$row->status.'</span>
                    <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm blogCategoryStatusBtn"><i class="fa fa-ban"></i></button>
                    ';
                }else{
                    return'
                    <span class="badge bg-warning">'.$row->status.'</span>
                    <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm blogCategoryStatusBtn"><i class="fa fa-check"></i></button>
                    ';
                }
            })
            ->addColumn('action', function($row){
                $btn = '
                <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editBlogCategoryModelBtn" data-toggle="modal" data-target="#editBlogCategoryModel"><i class="fa fa-pencil-square-o"></i></button>
                <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteBlogCategoryBtn"><i class="fa fa-trash"></i></button>
                    ';
                return $btn;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
        }

        return view('admin.blog.category.index');
    }

    public function fetchTrashedBlogCategory()
    {
        $send_trashed_blog_categories_data = "";

        $trashed_blog_categories = Blog_category::onlyTrashed()->get();

        foreach ($trashed_blog_categories as $trashed_blog_category){
            $send_trashed_blog_categories_data .= '
            <tr>
                <td>'.$trashed_blog_category->id.'</td>
                <td>'.$trashed_blog_category->blog_category_name.'</td>
                <td>
                    <button type="button" id="'.$trashed_blog_category->id.'" class="btn btn-success btn-sm blogCategoryRestoreBtn"><i class="fa fa-undo"></i></button>
                    <button type="button" id="'.$trashed_blog_category->id.'" class="btn btn-danger btn-sm blogCategoryForceDeleteBtn"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            ';
        }

        return response()->json([
            'trashed_blog_categories' => $send_trashed_blog_categories_data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'blog_category_name' => 'required|unique:blog_categories',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=>$validator->errors()->toArray()
            ]);
        }else{
            $blog_category_slug = Str::slug($request->blog_category_name);

            Blog_category::insert([
                'blog_category_name' => $request->blog_category_name,
                'blog_category_slug' => $blog_category_slug,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Blog category create successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $blog_category = Blog_category::where('id', $id)->first();
        return response()->json($blog_category);
    }

    public function update(Request $request, $id)
    {
        $blog_category = Blog_category::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            'blog_category_name' => 'required|unique:blog_categories,blog_category_name,'. $blog_category->id,
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $blog_category_slug = Str::slug($request->blog_category_name);

            $blog_category->update([
                'blog_category_name' => $request->blog_category_name,
                'blog_category_slug' => $blog_category_slug,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Blog category update successfully',
            ]);
        }
    }

    public function destroy($id)
    {
        $blog_category = Blog_category::where('id', $id)->first();
        $blog_category->updated_by = Auth::guard('admin')->user()->id;
        $blog_category->deleted_by = Auth::guard('admin')->user()->id;
        $blog_category->save();
        $blog_category->delete();
        return response()->json([
            'message' => 'Blog category destroy successfully',
        ]);
    }

    public function blogCategoryRestore($id)
    {
        Blog_category::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Blog_category::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Blog category restore successfully',
        ]);
    }

    public function blogCategoryForceDelete($id)
    {
        Blog_category::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Blog category force delete successfully',
        ]);
    }

    public function blogCategoryStatus($id){
        $blog_category = Blog_category::where('id', $id)->first();
        if($blog_category->status == "Yes"){
            $blog_category->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Blog category status inactive',
            ]);
        }else{
            $blog_category->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Blog category status active',
            ]);
        }
    }
}
