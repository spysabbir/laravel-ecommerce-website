<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $faqs = "";
            $query = Faq::select('faqs.*');

            if($request->status){
                $query->where('faqs.status', $request->status);
            }

            if($request->faq_position){
                $query->where('faqs.faq_position', $request->faq_position);
            }

            $faqs = $query->get();

            return Datatables::of($faqs)
                    ->addIndexColumn()
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm faqStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm faqStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editFaqModelBtn" data-toggle="modal" data-target="#editFaqModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteFaqBtn"><i class="fa fa-trash"></i></button>
                            ';
                        return $btn;
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
        }

        return view('admin.faq.index');
    }

    public function fetchTrashedFaq()
    {
        $send_trashed_faqs_data = "";

        $trashed_faqs = Faq::onlyTrashed()->get();

        foreach ($trashed_faqs as $trashed_faq){
            $send_trashed_faqs_data .= '
            <tr>
                <td>'.$trashed_faq->id.'</td>
                <td>'.$trashed_faq->faq_question.'</td>
                <td>
                    <button type="button" id="'.$trashed_faq->id.'" class="btn btn-success btn-sm faqRestoreBtn"><i class="fa fa-undo"></i></button>
                    <button type="button" id="'.$trashed_faq->id.'" class="btn btn-danger btn-sm faqForceDeleteBtn"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            ';
        }

        return response()->json([
            'trashed_faqs' => $send_trashed_faqs_data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'faq_question' => 'required|unique:faqs',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            Faq::insert([
                'faq_position' => $request->faq_position,
                'faq_question' => $request->faq_question,
                'faq_answer' => $request->faq_answer,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Faq create successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $faq = Faq::where('id', $id)->first();
        return response()->json($faq);
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'faq_question' => 'required|unique:faqs,faq_question,'. $faq->id,
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $faq->update([
                'faq_position' => $request->faq_position,
                'faq_question' => $request->faq_question,
                'faq_answer' => $request->faq_answer,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Faq update successfully',
            ]);
        }
    }

    public function destroy($id)
    {
        $faq = Faq::where('id', $id)->first();
        $faq->updated_by = Auth::guard('admin')->user()->id;
        $faq->deleted_by = Auth::guard('admin')->user()->id;
        $faq->save();
        $faq->delete();
        return response()->json([
            'message' => 'Faq destroy successfully',
        ]);
    }

    public function faqRestore($id)
    {
        Faq::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);
        Faq::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Faq restore successfully',
        ]);
    }

    public function faqForceDelete($id)
    {
        unlink(base_path("public/uploads/faq_photo/").Faq::onlyTrashed()->where('id', $id)->first()->faq_photo);
        Faq::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Faq force delete successfully',
        ]);
    }

    public function faqStatus($id){
        $faq = Faq::where('id', $id)->first();
        if($faq->status == "Yes"){
            $faq->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Faq status inactive',
            ]);
        }else{
            $faq->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Faq status active',
            ]);
        }
    }

}
