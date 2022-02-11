<?php

namespace App\Http\Controllers;

use App\Mail\MailProject;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::where('type', 'Client')->where('status', 1)->get();

        if(Auth::user()->type === 'Admin') {
            $data = DB::table('projects')
            ->leftJoin('users', 'projects.user_id', '=', 'users.id')
            ->select('projects.*', 'users.name')
            ->get();
        } else {
            $data = DB::table('projects')
                ->leftJoin('users', 'projects.user_id', '=', 'users.id')
                ->select('projects.*', 'users.name')
                ->where('user_id', Auth::user()->id)
                ->get();
        }
        if (request()->ajax()) {
            return datatables()->of($data)
                ->editColumn('status', function($project) {
                    if($project->status == '1') {
                        return '<span class="badge bg-success">Active</span>';
                    } else {
                        return '<span class="badge bg-danger">Inactive</span>';
                    }
                })
                ->addColumn('action', function ($data) {
                    $button = " <button class='editProject btn btn-secondary btn-sm' id='" . $data->id . "'><i class='fa fa-edit'></i></button>";
                    $button .= " <button class='destroyProject btn btn-danger btn-sm' id='" . $data->id . "'><i class='fa fa-ban'></i></button>";
                    return $button;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('projects.index', compact('data', 'users'));
    }

    public function store(Request $request)
    {
        $data = new Project();
        $data->user_id = $request->user_id;
        $data->project = $request->project;
        $data->currency = $request->currency;
        $data->hour_value = $request->hour_value;
        $data->status = $request->status;
        $project = $data->save();

        //SETA O PROJETO COMO DEFAULT
        $currentId = User::find($request->user_id);
        $currentId->current_project_id = $data->id;
        $currentId->save();

        if ($project) {
            //SEND MAIL
            $user = User::find($request->user_id);

            $mail = new MailProject(
                $user->name,
                $request->project,
                Auth::user()->name,
                date('d/m/Y H:i')
            );
            $mail->subject('Ghour - Project Started');
            Mail::to($user->email)->send($mail);

            return response()->json(["message" => "The project $request->project was successfully registered."]);
        } else {
            return response()->json(['message' => "Error registering."]);
        }
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $data = Project::find($id);
        return response()->json(['data' => $data]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $datas = [
            'user_id' => $request->user_id,
            'project' => $request->project,
            'currency' => $request->currency,
            'hour_value' => $request->hour_value,
            'status' => $request->status
        ];

        $data = Project::find($id);
        $project = $data->update($datas);

        if ($project) {
            return response()->json(["message" => "The project $request->project was successfully updated."]);
        } else {
            return response()->json(['message' => "Error to update."]);
        }
    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $data = Project::find($id);
        return response()->json(['data' => $data]);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        //SETA O PROJETO COMO DEFAULT
        $currentId = User::where('current_project_id', $id)->get();
        foreach($currentId as $idUser) {
            $idUser->current_project_id = 0;
            $idUser->save();
        }

        $data = Project::find($id);
        $project = $data->delete();

        if ($project) {
            return response()->json(["message" => "The project $request->project was successfully deleted."]);
        } else {
            return response()->json(['message' => "Error to remove."]);
        }
    }
}
