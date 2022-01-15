<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->type === 'Admin') {
            $projects = Project::where('status', 1)->get();
        } else {
            $projects = Project::where('status', 1)->where('user_id', Auth::user()->id)->get();
        }

        $data = Report::get();
        if (request()->ajax()) {
            return datatables()->of($data)
                ->addColumn('action', function ($data) {
                    $button = "<button class='printPdf btn btn-outline-primary btn-sm' id='" . $data->id . "'><i class='fa fa-file-pdf'></i></button>";
                    return $button;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('reports.index', compact(['data', 'projects']));
    }
}
