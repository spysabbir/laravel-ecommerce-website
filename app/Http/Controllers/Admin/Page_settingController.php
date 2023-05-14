<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page_setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Page_settingController extends Controller
{
    public function index()
    {
        $page_settings = Page_setting::all();
        $trashed_page_settings = Page_setting::onlyTrashed()->get();
        return view('admin.setting.page.index', compact('page_settings', 'trashed_page_settings'));
    }

    public function create()
    {
        return view('admin.setting.page.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            '*' => 'required',
            'page_name' => 'required|unique:page_settings',
            'files' => 'nullable',
        ]);

        $page_slug = Str::slug($request->page_name);

        Page_setting::insert([
            'page_position' => $request->page_position,
            'page_name' => $request->page_name,
            'page_slug' => $page_slug,
            'page_content' => $request->page_content,
            'created_by' => Auth::guard('admin')->user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Page details create successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('page-setting.index')->with($notification);
    }

    public function show($id)
    {
        $page_setting = Page_setting::where('id', $id)->first();
        return view('admin.setting.page.view', compact('page_setting'));
    }

    public function edit($id)
    {
        $page_setting = Page_setting::where('id', $id)->first();
        return view('admin.setting.page.edit', compact('page_setting'));
    }

    public function update(Request $request, $id)
    {
        $page_setting = Page_setting::where('id', $id)->first();

        $request->validate([
            '*' => 'required',
            'page_name' => 'required|unique:page_settings,page_name,'. $page_setting->id,
            'files' => 'nullable',
        ]);

        $page_slug = Str::slug($request->page_name);

        $page_setting->update([
            'page_position' => $request->page_position,
            'page_name' => $request->page_name,
            'page_slug' => $page_slug,
            'page_content' => $request->page_content,
            'updated_by' => Auth::guard('admin')->user()->id,
        ]);
        $notification = array(
            'message' => 'Page details updated successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('page-setting.index')->with($notification);
    }

    public function destroy($id)
    {
        $page_setting = Page_setting::where('id', $id)->first();

        $page_setting->updated_by = Auth::guard('admin')->user()->id;
        $page_setting->deleted_by = Auth::guard('admin')->user()->id;
        $page_setting->save();
        $page_setting->delete();

        $notification = array(
            'message' => 'Page destroy successfully.',
            'alert-type' => 'warning'
        );
        return back()->with($notification);
    }

    public function pageSettingRestore($id)
    {
        Page_setting::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);

        Page_setting::onlyTrashed()->where('id', $id)->restore();

        $notification = array(
            'message' => 'Page restore successfully.',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

    public function pageSettingForceDelete($id)
    {
        Page_setting::onlyTrashed()->where('id', $id)->forceDelete();
        $notification = array(
            'message' => 'Page force delete successfully.',
            'alert-type' => 'error'
        );
        return back()->with($notification);
    }

    public function pageSettingStatus($id){
        $page_setting = Page_setting::where('id', $id)->first();
        if($page_setting->status == "Yes"){
            $page_setting->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            $notification = array(
                'message' => 'Page status inactive successfully.',
                'alert-type' => 'info'
            );
            return back()->with($notification);
        }else{
            $page_setting->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            $notification = array(
                'message' => 'Page status active successfully.',
                'alert-type' => 'info'
            );
            return back()->with($notification);
        }
    }
}
