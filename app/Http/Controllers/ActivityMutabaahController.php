<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ActivityMutabaahController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Activity::select('*')->orderBy('created_at', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="row"><a href="javascript:void(0)" id="' . $row->id . '" class="btn btn-primary btn-sm ml-2 btn-edit">Edit</a>';
                    $btn .= '<a href="javascript:void(0)" id="' . $row->id . '" class="btn btn-danger btn-sm ml-2 btn-delete">Delete</a></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            dd($request->all());
        }

        return view('admin.user.index');
    }
}
