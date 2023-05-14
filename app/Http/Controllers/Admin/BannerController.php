<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $banners = "";
            $query = Banner::select('banners.*');

            if($request->status){
                $query->where('banners.status', $request->status);
            }

            if($request->banner_position){
                $query->where('banners.banner_position', $request->banner_position);
            }

            $banners = $query->get();

            return Datatables::of($banners)
                    ->addIndexColumn()
                    ->editColumn('banner_photo', function($row){
                        return '<img src="'.asset('uploads/banner_photo').'/'.$row->banner_photo.'" width="40" >';
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm bannerStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm bannerStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editBannerModelBtn" data-toggle="modal" data-target="#editBannerModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteBannerBtn"><i class="fa fa-trash"></i></button>
                            ';
                        return $btn;
                    })
                    ->rawColumns(['banner_photo', 'status', 'action'])
                    ->make(true);
        }

        return view('admin.banner.index');
    }

    public function fetchTrashedBanner()
    {
        $send_trashed_banners_data = "";

        $trashed_banners = Banner::onlyTrashed()->get();

        foreach ($trashed_banners as $trashed_banner){
            $send_trashed_banners_data .= '
            <tr>
                <td>'.$trashed_banner->id.'</td>
                <td>'.$trashed_banner->banner_title.'</td>
                <td>
                    <button type="button" id="'.$trashed_banner->id.'" class="btn btn-success btn-sm bannerRestoreBtn"><i class="fa fa-undo"></i></button>
                    <button type="button" id="'.$trashed_banner->id.'" class="btn btn-danger btn-sm bannerForceDeleteBtn"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            ';
        }

        return response()->json([
            'trashed_banners' => $send_trashed_banners_data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'banner_photo' => 'required|image|mimes:png,jpg,jpeg,webp,svg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=>$validator->errors()->toArray()
            ]);
        }else{
            // Banner Photo Upload
            $banner_photo_name =  "Banner-Photo-".Str::random(5).".". $request->file('banner_photo')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/banner_photo/").$banner_photo_name;
            Image::make($request->file('banner_photo'))->resize(450, 200)->save($upload_link);

            Banner::insert([
                'banner_position' => $request->banner_position,
                'banner_title' => $request->banner_title,
                'banner_subtitle' => $request->banner_subtitle,
                'banner_link' => $request->banner_link,
                'banner_photo' => $banner_photo_name,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Banner create successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $banner = Banner::where('id', $id)->first();
        return response()->json($banner);
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::where('id', $id)->first();
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'banner_photo' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            // Banner Photo Upload
            if($request->hasFile('banner_photo')){
                unlink(base_path("public/uploads/banner_photo/").$banner->banner_photo);
                $banner_photo_name =  "Banner-Photo-".Str::random(5).".". $request->file('banner_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/banner_photo/").$banner_photo_name;
                Image::make($request->file('banner_photo'))->resize(450, 200)->save($upload_link);
                $banner->update([
                    'banner_photo' => $banner_photo_name,
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);
            }

            $banner->update([
                'banner_position' => $request->banner_position,
                'banner_title' => $request->banner_title,
                'banner_subtitle' => $request->banner_subtitle,
                'banner_link' => $request->banner_link,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Banner update successfully',
            ]);
        }
    }

    public function destroy($id)
    {
        $banner = Banner::where('id', $id)->first();

        $banner->updated_by = Auth::guard('admin')->user()->id;
        $banner->deleted_by = Auth::guard('admin')->user()->id;
        $banner->save();
        $banner->delete();
        return response()->json([
            'message' => 'Banner destroy successfully',
        ]);
    }

    public function bannerRestore($id)
    {
        Banner::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Banner::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Banner restore successfully',
        ]);
    }

    public function bannerForceDelete($id)
    {
        unlink(base_path("public/uploads/banner_photo/").Banner::onlyTrashed()->where('id', $id)->first()->banner_photo);
        Banner::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Banner force delete successfully',
        ]);
    }

    public function bannerStatus($id){
        $banner = Banner::where('id', $id)->first();
        if($banner->status == "Yes"){
            $banner->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Banner status inactive',
            ]);
        }else{
            $banner->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Banner status active',
            ]);
        }
    }
}
