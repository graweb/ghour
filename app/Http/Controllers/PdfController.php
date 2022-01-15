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
            ->whereNotNull('end_datetime')
            ->get();
        }
        else
        {
            $tasks = DB::table('vw_tasks')
            ->where('project_id', $request->project_id)
            ->whereNull('end_datetime')
            ->get();
        }

        $project = Project::find($request->project_id);
        $user = User::where('current_project_id', $request->project_id)->where('type', 'Client')->first();

        $pdf = PDF::loadView('reports.invoice', compact(['tasks', 'project', 'user']));
        return $pdf->setPaper('a4')->stream('Invoice.pdf');
    }

    public function report(Request $request)
    {
        $tasks = DB::table('vw_tasks')
            ->where('project_id', $request->project_id)
            ->get();

        $user = User::where('current_project_id', $request->project_id)->where('type', 'Client')->first();

        $pdf = PDF::loadView('reports.report', compact(['tasks', 'user']));
        return $pdf->setPaper('a4')->stream('Report.pdf');
    }
}
