<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sliders = "";
            $query = Slider::select('sliders.*');

            if($request->status){
                $query->where('sliders.status', $request->status);
            }

            $sliders = $query->get();

            return Datatables::of($sliders)
                    ->addIndexColumn()
                    ->editColumn('slider_photo', function($row){
                        return '<img src="'.asset('uploads/slider_photo').'/'.$row->slider_photo.'" width="40" >';
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm sliderStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm sliderStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editSliderModelBtn" data-toggle="modal" data-target="#editSliderModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteSliderBtn"><i class="fa fa-trash"></i></button>
                            ';
                        return $btn;
                    })
                    ->rawColumns(['slider_photo', 'status', 'action'])
                    ->make(true);
        }

        return view('admin.slider.index');
    }

    public function fetchTrashedSlider()
    {
        $send_trashed_sliders_data = "";
        $trashed_sliders = Slider::onlyTrashed()->get();

        foreach ($trashed_sliders as $trashed_slider){
            $send_trashed_sliders_data .= '
            <tr>
                <td>'.$trashed_slider->id.'</td>
                <td>'.$trashed_slider->slider_title.'</td>
                <td>
                    <button type="button" id="'.$trashed_slider->id.'" class="btn btn-success btn-sm sliderRestoreBtn"><i class="fa fa-undo"></i></button>
                    <button type="button" id="'.$trashed_slider->id.'" class="btn btn-danger btn-sm sliderForceDeleteBtn"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            ';
        }

        return response()->json([
            'trashed_sliders' => $send_trashed_sliders_data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'slider_photo' => 'required|image|mimes:png,jpg,jpeg,webp,svg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            // Slider Photo Upload
            $slider_photo_name =  "Slider-Photo-".Str::random(5).".". $request->file('slider_photo')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/slider_photo/").$slider_photo_name;
            Image::make($request->file('slider_photo'))->resize(1920, 500)->save($upload_link);

            Slider::insert([
                'slider_title' => $request->slider_title,
                'slider_subtitle' => $request->slider_subtitle,
                'slider_link' => $request->slider_link,
                'slider_photo' => $slider_photo_name,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Slider create successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $slider = Slider::where('id', $id)->first();
        return response()->json($slider);
    }

    public function update(Request $request, $id)
    {
        $slider = Slider::where('id', $id)->first();
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'slider_photo' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            // Slider Photo Upload
            if($request->hasFile('slider_photo')){
                unlink(base_path("public/uploads/slider_photo/").$slider->slider_photo);
                $slider_photo_name =  "Slider-Photo-".Str::random(5).".". $request->file('slider_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/slider_photo/").$slider_photo_name;
                Image::make($request->file('slider_photo'))->resize(1920, 500)->save($upload_link);
                $slider->update([
                    'slider_photo' => $slider_photo_name,
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);
            }

            $slider->update([
                'slider_title' => $request->slider_title,
                'slider_subtitle' => $request->slider_subtitle,
                'slider_link' => $request->slider_link,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Slider update successfully',
            ]);
        }
    }

    public function destroy($id)
    {
        $slider = Slider::where('id', $id)->first();
        $slider->updated_by = Auth::guard('admin')->user()->id;
        $slider->deleted_by = Auth::guard('admin')->user()->id;
        $slider->save();
        $slider->delete();
        return response()->json([
            'message' => 'Slider destroy successfully',
        ]);
    }

    public function sliderRestore($id)
    {
        Slider::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Slider::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Slider restore successfully',
        ]);
    }

    public function sliderForceDelete($id)
    {
        unlink(base_path("public/uploads/slider_photo/").Slider::onlyTrashed()->where('id', $id)->first()->slider_photo);
        Slider::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Slider force delete successfully',
        ]);
    }

    public function sliderStatus($id){
        $slider = Slider::where('id', $id)->first();
        if($slider->status == "Yes"){
            $slider->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Slider status inactive',
            ]);
        }else{
            $slider->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Slider status active',
            ]);
        }
    }
}
