<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Blog_category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $blogs = "";
            $query = Blog::leftJoin('blog_categories', 'blogs.blog_category_id', 'blog_categories.id');

            if($request->blog_category_id){
                $query->where('blogs.blog_category_id', $request->blog_category_id);
            }

            if($request->status){
                $query->where('blogs.status', $request->status);
            }

            if($request->created_at){
                $query->where('blogs.created_at', 'LIKE', '%'.$request->created_at.'%');
            }

            $blogs = $query->select('blogs.*', 'blog_categories.blog_category_name')
            ->get();

            return Datatables::of($blogs)
                    ->addIndexColumn()
                    ->editColumn('thumbnail_photo', function($row){
                        return '<img src="'.asset('uploads/blog_thumbnail_photo').'/'.$row->blog_thumbnail_photo.'" width="40" >';
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm blogStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm blogStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->editColumn('created_at', function($row){
                        return'
                        <span class="badge bg-light">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
                        ';
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm viewBlogModelBtn" data-toggle="modal" data-target="#viewBlogDetailsModel"><i class="fa fa-eye"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editBlogModelBtn" data-toggle="modal" data-target="#editBlogModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteBlogBtn"><i class="fa fa-trash"></i></button>
                            ';
                        return $btn;
                    })
                    ->rawColumns(['thumbnail_photo', 'blog_category_name', 'created_at', 'status', 'action'])
                    ->make(true);
        }

        $blog_categories = Blog_category::all();
        return view('admin.blog.index', compact('blog_categories'));
    }

    public function fetchTrashedBlog()
    {
        $send_trashed_blogs_data = "";

        $trashed_blogs = Blog::onlyTrashed()->get();

        foreach ($trashed_blogs as $trashed_blog){
            $send_trashed_blogs_data .= '
            <tr>
                <td>'.$trashed_blog->id.'</td>
                <td>'.$trashed_blog->blog_headline.'</td>
                <td>
                    <button type="button" id="'.$trashed_blog->id.'" class="btn btn-success btn-sm blogRestoreBtn"><i class="fa fa-undo"></i></button>
                    <button type="button" id="'.$trashed_blog->id.'" class="btn btn-danger btn-sm blogForceDeleteBtn"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            ';
        }

        return response()->json([
            'trashed_blogs' => $send_trashed_blogs_data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'blog_headline' => 'required|unique:blogs',
            'blog_thumbnail_photo' => 'nullable|image|mimes:png,jpg,jpeg,webp',
            'blog_cover_photo' => 'nullable|image|mimes:png,jpg,jpeg,webp',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=>$validator->errors()->toArray()
            ]);
        }else{
            $blog_slug = Str::slug($request->blog_headline).'-'.Str::random(10);
            $blog_id = Blog::insertGetId([
                'blog_headline' => $request->blog_headline,
                'blog_slug' => $blog_slug,
                'blog_category_id' => $request->blog_category_id,
                'blog_quota' => $request->blog_quota,
                'blog_details' => $request->blog_details,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
            ]);
            // Blog Thumbnail Photo Upload
            if($request->hasFile('blog_thumbnail_photo')){
                $blog_thumbnail_photo_name =  $blog_id."-Blog-Thumbnail-Photo-".Str::random(5).".". $request->file('blog_thumbnail_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/blog_thumbnail_photo/").$blog_thumbnail_photo_name;
                Image::make($request->file('blog_thumbnail_photo'))->resize(450, 180)->save($upload_link);
                Blog::find($blog_id)->update([
                    'blog_thumbnail_photo' => $blog_thumbnail_photo_name,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
            }
            // Blog Cover Photo Upload
            if($request->hasFile('blog_cover_photo')){
                $blog_cover_photo_name =  $blog_id."-Blog-Cover-Photo-".Str::random(5).".". $request->file('blog_cover_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/blog_cover_photo/").$blog_cover_photo_name;
                Image::make($request->file('blog_cover_photo'))->resize(850, 450)->save($upload_link);
                Blog::find($blog_id)->update([
                    'blog_cover_photo' => $blog_cover_photo_name,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Blog create successfully',
            ]);
        }
    }

    public function show($id)
    {
        $blog = Blog::where('id', $id)->first();
        return view('admin.blog.details', compact('blog'));
    }

    public function edit($id)
    {
        $blog = Blog::where('id', $id)->first();
        return response()->json($blog);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'blog_headline' => 'required|unique:blogs,blog_headline,'. $blog->id,
            'blog_thumbnail_photo' => 'nullable|image|mimes:png,jpg,jpeg,webp',
            'blog_cover_photo' => 'nullable|image|mimes:png,jpg,jpeg,webp',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $blog_slug = Str::slug($request->blog_headline).'-'.Str::random(10);
            // Blog Thumbnail Photo Upload
            if($request->hasFile('blog_thumbnail_photo')){
                if($blog->blog_thumbnail_photo != 'default_blog_thumbnail_photo.jpg'){
                    unlink(base_path("public/uploads/blog_thumbnail_photo/").$blog->blog_thumbnail_photo);
                }
                $blog_thumbnail_photo_name =  "Blog-Thumbnail-Photo-".Str::random(5).".". $request->file('blog_thumbnail_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/blog_thumbnail_photo/").$blog_thumbnail_photo_name;
                Image::make($request->file('blog_thumbnail_photo'))->resize(505, 316)->save($upload_link);
                $blog->update([
                    'blog_thumbnail_photo' => $blog_thumbnail_photo_name,
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);
            }
            // Blog Cover Photo Upload
            if($request->hasFile('blog_cover_photo')){
                if($blog->blog_cover_photo != 'default_blog_cover_photo.jpg'){
                    unlink(base_path("public/uploads/blog_cover_photo/").$blog->blog_cover_photo);
                }
                $blog_cover_photo_name =  "Blog-Cover-Photo-".Str::random(5).".". $request->file('blog_cover_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/blog_cover_photo/").$blog_cover_photo_name;
                Image::make($request->file('blog_cover_photo'))->resize(850, 450)->save($upload_link);
                $blog->update([
                    'blog_cover_photo' => $blog_cover_photo_name,
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);
            }

            $blog->update([
                'blog_headline' => $request->blog_headline,
                'blog_slug' => $blog_slug,
                'blog_category_id' => $request->blog_category_id,
                'blog_quota' => $request->blog_quota,
                'blog_details' => $request->blog_details,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Blog update successfully',
            ]);
        }
    }

    public function destroy($id)
    {
        $blog = Blog::where('id', $id)->first();
        $blog->updated_by = Auth::guard('admin')->user()->id;
        $blog->deleted_by = Auth::guard('admin')->user()->id;
        $blog->save();
        $blog->delete();
        return response()->json([
            'message' => 'Blog destroy successfully',
        ]);
    }

    public function blogRestore($id)
    {
        Blog::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Blog::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Blog restore successfully',
        ]);
    }

    public function blogForceDelete($id)
    {
        if(Blog::onlyTrashed()->where('id', $id)->first()->blog_thumbnail_photo != 'default_blog_thumbnail_photo.jpg'){
            unlink(base_path("public/uploads/blog_thumbnail_photo/").Blog::onlyTrashed()->where('id', $id)->first()->blog_thumbnail_photo);
        }
        if(Blog::onlyTrashed()->where('id', $id)->first()->blog_cover_photo != 'default_blog_cover_photo.jpg'){
            unlink(base_path("public/uploads/blog_cover_photo/").Blog::onlyTrashed()->where('id', $id)->first()->blog_cover_photo);
        }
        Blog::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Blog force delete successfully',
        ]);
    }

    public function blogStatus($id){
        $blog = Blog::where('id', $id)->first();
        if($blog->status == "Yes"){
            $blog->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Blog status inactive',
            ]);
        }else{
            $blog->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Blog status active',
            ]);
        }
    }
}
