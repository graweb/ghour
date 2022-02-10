<?php

namespace App\Http\Controllers;

use App\Mail\MailTask;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->type === 'Admin') {

            $projects = Project::where('status', 1)->get();

            $data = DB::table('tasks')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->select('tasks.*', 'projects.project')
            ->orderBy('tasks.id', 'desc')
            ->get();

        } else {

            $projects = Project::where('user_id', Auth::user()->id)->where('status', 1)->get();

            $data = DB::table('tasks')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->select('tasks.*', 'projects.project')
            ->where('user_id', Auth::user()->id)
            ->orderBy('tasks.id', 'desc')
            ->get();
        }

        if (request()->ajax()) {
            return datatables()->of($data)
                ->editColumn('start_datetime', function ($data) {
                    return date('d/m/Y H:i', strtotime($data->start_datetime)) . "hs";
                })
                ->editColumn('end_datetime', function ($data) {
                    if(!is_null($data->end_datetime))
                    {
                        return date('d/m/Y H:i', strtotime($data->end_datetime)) . "hs";
                    }
                })
                ->addColumn('action', function ($data) {

                    if(Auth::user()->type === 'Admin') {
                        if(!is_null($data->end_datetime)) {
                            $button = "<button class='stopTask btn btn-info btn-sm disabled' id='" . $data->id . "'><i class='fa fa-stop'></i></button>";
                            if($data->paid === '1') {
                                $button .= " <button class='paidTask btn btn-success btn-sm disabled' id='" . $data->id . "'><i class='fa fa-dollar'></i></button>";
                            } else {
                                $button .= " <button class='paidTask btn btn-success btn-sm' id='" . $data->id . "'><i class='fa fa-dollar'></i></button>";
                            }

                            //$button .= " <button class='editTask btn btn-secondary btn-sm disabled' id='" . $data->id . "'><i class='fa fa-edit'></i></button>";
                            //$button .= " <button class='destroyTask btn btn-danger btn-sm disabled' id='" . $data->id . "'><i class='fa fa-ban'></i></button>";
                        } else {
                            $button = "<button class='stopTask btn btn-info btn-sm' id='" . $data->id . "'><i class='fa fa-stop'></i></button>";
                            $button .= " <button class='paidTask btn btn-success btn-sm' id='" . $data->id . "'><i class='fa fa-dollar'></i></button>";
                            //$button .= " <button class='editTask btn btn-secondary btn-sm' id='" . $data->id . "'><i class='fa fa-edit'></i></button>";
                            //$button .= " <button class='destroyTask btn btn-danger btn-sm' id='" . $data->id . "'><i class='fa fa-ban'></i></button>";
                        }
                    } else {
                        if(is_null($data->end_datetime)) {
                            $button = "<span class='badge badge-warning'>In progress</span>";
                        } else {
                            $button = "<span class='badge badge-success'>Done</span>";
                        }
                    }

                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('tasks.index', compact('data', 'projects'));
    }

    public function store(Request $request)
    {
        date_default_timezone_set('America/Sao_Paulo');

        $data = new Task();
        $data->project_id = $request->project_id;
        $data->task = $request->task;
        $task = $data->save();

        if ($task) {
            //SEND MAIL
            $project = Project::find($request->project_id);
            $user = User::find($project->user_id);

            $mail = new MailTask(
                $user->name,
                Auth::user()->name,
                $request->task,
                $project->project,
                date('d/m/Y H:i'),
                'Started'
            );
            $mail->subject('Ghour - Task Started');
            Mail::to($user->email)->send($mail);

            return response()->json(["message" => "The task $request->task was successfully registered."]);
        } else {
            return response()->json(['message' => "Error registering."]);
        }
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $data = Task::find($id);
        return response()->json(['data' => $data]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $datas = [
            'project_id' => $request->project_id,
            'task' => $request->task
        ];

        $data = Task::find($id);
        $task = $data->update($datas);

        if ($task) {
            return response()->json(["message" => "The task $request->task was successfully updated."]);
        } else {
            return response()->json(['message' => "Error to update."]);
        }
    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $data = Task::find($id);
        return response()->json(['data' => $data]);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $data = Task::find($id);
        $task = $data->delete();

        if ($task) {
            return response()->json(["message" => "The task $request->task was successfully deleted."]);
        } else {
            return response()->json(['message' => "Error to remove."]);
        }
    }

    public function stop(Request $request)
    {
        $id = $request->id;
        $data = Task::find($id);
        return response()->json(['data' => $data]);
    }

    public function done(Request $request)
    {
        date_default_timezone_set('America/Sao_Paulo');

        $task = Task::find($request->id);
        $task->end_datetime = date('Y-m-d H:i:s');
        $task = $task->save();

        if ($task) {
            //SEND MAIL
            $project = Project::find($request->project_id_stop);
            $user = User::find($project->user_id);

            $mail = new MailTask(
                $user->name,
                Auth::user()->name,
                $request->task_stop,
                $project->project,
                date('d/m/Y H:i'),
                'Finished'
            );
            $mail->subject('Ghour - Task Finished');
            Mail::to($user->email)->send($mail);

            return response()->json(["message" => "The task $request->task_stop was successfully finished."]);
        } else {
            return response()->json(['message' => "Error to finish."]);
        }
    }

    public function paid(Request $request)
    {
        $id = $request->id;
        $data = Task::find($id);
        return response()->json(['data' => $data]);
    }

    public function finish(Request $request)
    {
        $task = Task::find($request->id);
        $task->paid = 1;
        $task = $task->save();

        if ($task) {
            return response()->json(["message" => "The task $request->task was successfully paid."]);
        } else {
            return response()->json(['message' => "Error to paid."]);
        }
    }
}
