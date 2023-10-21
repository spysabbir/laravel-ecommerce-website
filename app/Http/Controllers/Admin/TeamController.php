<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $teams = "";
            $query = Team::select('teams.*');

            if($request->status){
                $query->where('teams.status', $request->status);
            }

            $teams = $query->get();

            return Datatables::of($teams)
                    ->addIndexColumn()
                    ->editColumn('team_member_photo', function($row){
                        return '<img src="'.asset('uploads/team_member_photo').'/'.$row->team_member_photo.'" width="40" >';
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm teamStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm teamStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm editTeamModelBtn" data-toggle="modal" data-target="#editTeamModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteTeamBtn"><i class="fa fa-trash"></i></button>
                            ';
                        return $btn;
                    })
                    ->rawColumns(['team_member_photo', 'status', 'action'])
                    ->make(true);
        }

        return view('admin.team.index');
    }

    public function fetchTrashedTeam()
    {
        $send_trashed_teams_data = "";

        $trashed_teams = Team::onlyTrashed()->get();

        foreach ($trashed_teams as $trashed_team){
            $send_trashed_teams_data .= '
            <tr>
                <td>'.$trashed_team->id.'</td>
                <td>'.$trashed_team->team_member_name.'</td>
                <td>
                    <button type="button" id="'.$trashed_team->id.'" class="btn btn-success btn-sm teamRestoreBtn"><i class="fa fa-undo"></i></button>
                    <button type="button" id="'.$trashed_team->id.'" class="btn btn-danger btn-sm teamForceDeleteBtn"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            ';
        }

        return response()->json([
            'trashed_team' => $send_trashed_teams_data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'team_member_photo' => 'required|image|mimes:png,jpg,jpeg,webp',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=>$validator->errors()->toArray()
            ]);
        }else{
            // Team Member Photo Upload
            $team_member_photo_name =  "Team-Member-Photo-".Str::random(5).".". $request->file('team_member_photo')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/team_member_photo/").$team_member_photo_name;
            Image::make($request->file('team_member_photo'))->resize(260, 260)->save($upload_link);

            Team::insert([
                'team_member_name' => $request->team_member_name,
                'team_member_designation' => $request->team_member_designation,
                'team_member_photo' => $team_member_photo_name,
                'team_member_facebook_link' => $request->team_member_facebook_link,
                'team_member_twitter_link' => $request->team_member_twitter_link,
                'team_member_instagram_link' => $request->team_member_instagram_link,
                'team_member_linkedin_link' => $request->team_member_linkedin_link,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Team create successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $team = Team::where('id', $id)->first();
        return response()->json($team);
    }

    public function update(Request $request, $id)
    {
        $team = Team::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            '*' => 'required',
            'team_member_photo' => 'nullable|image|mimes:png,jpg,jpeg,webp',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            // Team Member Photo Upload
            if($request->hasFile('team_member_photo')){
                unlink(base_path("public/uploads/team_member_photo/").$team->team_member_photo);
                $team_member_photo_name =  "Team-Member-Photo-".Str::random(5).".". $request->file('team_member_photo')->getClientOriginalExtension();
                $upload_link = base_path("public/uploads/team_member_photo/").$team_member_photo_name;
                Image::make($request->file('team_member_photo'))->resize(260, 260)->save($upload_link);
                $team->update([
                    'team_member_photo' => $team_member_photo_name,
                    'updated_by' => Auth::guard('admin')->user()->id,
                ]);
            }

            $team->update([
                'team_member_name' => $request->team_member_name,
                'team_member_designation' => $request->team_member_designation,
                'team_member_facebook_link' => $request->team_member_facebook_link,
                'team_member_twitter_link' => $request->team_member_twitter_link,
                'team_member_instagram_link' => $request->team_member_instagram_link,
                'team_member_linkedin_link' => $request->team_member_linkedin_link,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Team update successfully',
            ]);
        }
    }

    public function destroy($id)
    {
        $team = Team::where('id', $id)->first();

        $team->updated_by = Auth::guard('admin')->user()->id;
        $team->deleted_by = Auth::guard('admin')->user()->id;
        $team->save();
        $team->delete();
        return response()->json([
            'message' => 'Team destroy successfully',
        ]);
    }

    public function teamRestore($id)
    {
        Team::onlyTrashed()->where('id', $id)->update([
            'deleted_by' => NULL
        ]);

        Team::onlyTrashed()->where('id', $id)->restore();
        return response()->json([
            'message' => 'Team restore successfully',
        ]);
    }

    public function teamForceDelete($id)
    {
        unlink(base_path("public/uploads/team_member_photo/").Team::onlyTrashed()->where('id', $id)->first()->team_member_photo);
        Team::onlyTrashed()->where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Team force delete successfully',
        ]);
    }

    public function teamStatus($id){
        $team = Team::where('id', $id)->first();
        if($team->status == "Yes"){
            $team->update([
                'status' => "No",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Team status inactive',
            ]);
        }else{
            $team->update([
                'status' =>"Yes",
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'message' => 'Team status active',
            ]);
        }
    }
}
