<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = User::get();
        if (request()->ajax()) {
            return datatables()->of($data)
                ->editColumn('status', function(User $user) {
                    if($user->status === 1) {
                        return '<span class="badge bg-success">Active</span>';
                    } else {
                        return '<span class="badge bg-danger">Inactive</span>';
                    }
                })
                ->addColumn('action', function ($data) {
                    $button = " <button class='editUser btn btn-secondary btn-sm' id='" . $data->id . "'><i class='fa fa-edit'></i></button>";
                    $button .= " <button class='destroyUser btn btn-danger btn-sm' id='" . $data->id . "'><i class='fa fa-ban'></i></button>";
                    return $button;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('users.index', compact('data'));
    }

    public function store(Request $request)
    {
        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->company = $request->company;
        $data->address = $request->address;
        $data->contact = $request->contact;
        $data->type = $request->type;
        $data->status = $request->status;
        $user = $data->save();

        if ($user) {
            return response()->json(["message" => "The user $request->name was successfully registered."]);
        } else {
            return response()->json(['message' => "Error registering."]);
        }
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $data = User::find($id);
        return response()->json(['data' => $data]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $datas = [
            'name' => $request->name,
            'email' => $request->email,
            'company' => $request->company,
            'address' => $request->address,
            'contact' => $request->contact,
            'type' => $request->type,
            'status' => $request->status
        ];

        $data = User::find($id);
        $user = $data->update($datas);

        if ($user) {
            return response()->json(["message" => "The user $request->name was successfully updated."]);
        } else {
            return response()->json(['message' => "Error to update."]);
        }
    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $data = User::find($id);
        return response()->json(['data' => $data]);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $data = User::find($id);

        //SETA O PROJETO COMO DEFAULT
        $currentId = User::where('current_project_id', $data->current_project_id)->get();
        foreach($currentId as $idUser) {
            $idUser->current_project_id = 0;
            $idUser->save();
        }

        $user = $data->delete();

        if ($user) {
            return response()->json(["message" => "The user $request->name was successfully deleted."]);
        } else {
            return response()->json(['message' => "Error to remove."]);
        }
    }

    public function updateCurrentProjectId(Request $request)
    {
        $currentId = User::find(Auth::user()->id);
        $currentId->current_project_id = $request->current_project_id;
        $projectId = $currentId->save();

        if ($projectId) {
            return response()->json(["message" => "The project data are successfully updated."]);
        } else {
            return response()->json(['message' => "Error to update."]);
        }
    }
}
