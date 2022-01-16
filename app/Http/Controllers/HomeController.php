<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->type === 'Admin') {
            $projects = Project::where('id', '!=', Auth::user()->current_project_id)->get();

            $projectsActive = Project::all()->where('status', 1)->count();
            $projectsInactive = Project::all()->where('status', 0)->count();
            $tasksPaid = Task::all()->where('paid', 1)->where('project_id', Auth::user()->current_project_id)->count();
            $tasksUnpaid = Task::all()->where('paid', 0)->where('project_id', Auth::user()->current_project_id)->count();
        } else {
            $project = Project::find(Auth::user()->current_project_id);
            $projects = Project::where('user_id', Auth::user()->id)->where('id', '!=', Auth::user()->current_project_id)->get();

            $projectsActive = Project::all()->where('user_id', Auth::user()->id)->where('status', 1)->count();
            $projectsInactive = Project::all()->where('user_id', Auth::user()->id)->where('status', 0)->count();

            if(!is_null($project)) {
                $tasksPaid = Task::all()->where('project_id', $project->id)->where('paid', 1)->count();
                $tasksUnpaid = Task::all()->where('project_id', $project->id)->where('paid', 0)->count();
            } else {
                $tasksPaid = 0;
                $tasksUnpaid = 0;
            }
        }

        $projectHourValue = Project::find(Auth::user()->current_project_id);
        $tasks = DB::table('vw_tasks')->where('project_id', Auth::user()->current_project_id)->where('paid', '0')->get();

        return view('home', compact('projectsActive', 'projectsInactive', 'tasksPaid', 'tasksUnpaid', 'tasks', 'projects', 'projectHourValue'));
    }
}
