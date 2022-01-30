<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function invoice(Request $request)
    {
        if($request->status === "0")
        {
            $tasks = DB::table('vw_tasks')
            ->where('project_id', $request->project_id)
            ->where('paid', $request->paid)
            ->whereNotNull('end_datetime')
            ->get();
        }
        else
        {
            $tasks = DB::table('vw_tasks')
            ->where('project_id', $request->project_id)
            ->where('paid', $request->paid)
            ->whereNull('end_datetime')
            ->get();
        }

        $project = Project::find($request->project_id);

        // $user = User::where('id', $request->project_id)->where('type', 'Client')->first();
        $user = DB::table('users')
                    ->join('projects', 'users.id', '=', 'projects.user_id')
                    ->where('projects.id', $request->project_id)
                    ->where('type', 'Client')
                    ->select('users.*')
                    ->first();

        $userAdmin = User::where('type', 'Admin')->first();

        $pdf = PDF::loadView('reports.invoice', compact(['tasks', 'project', 'user', 'userAdmin']));
        return $pdf->setPaper('a4')->stream('Invoice.pdf');
    }

    public function report(Request $request)
    {
        $tasks = DB::table('vw_tasks')
            ->where('project_id', $request->project_id)
            ->get();

        $user = DB::table('users')
            ->join('projects', 'users.id', '=', 'projects.user_id')
            ->where('projects.id', $request->project_id)
            ->where('type', 'Client')
            ->select('users.*')
            ->first();

        $userAdmin = User::where('type', 'Admin')->first();

        $pdf = PDF::loadView('reports.report', compact(['tasks', 'user', 'userAdmin']));
        return $pdf->setPaper('a4')->stream('Report.pdf');
    }
}
