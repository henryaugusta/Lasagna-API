<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class GuruController extends Controller
{
    function guruViewProfile(Request $request)
    {

        $guru = Guru::find(Auth::guard('guru')->id());
        $widget = [
            "guru" => $guru,
        ];

        return view('guru.profile')->with(compact('widget'));
    }



    function guruChangePassword(Request $request)
    {
        $this->validate($request, [
            'new_password' => 'required|min:6'
        ]);

        $user = Guru::findOrFail(Auth::guard('guru')->id());
        $hasher = app('hash');
        if (!$hasher->check($request->old_password, $user->password)) {
            return back()->with(["error" => "Password Lama Tidak Sesuai"]);
        } else {
            $user->password = Hash::make($request->new_password);
            $user->save();

            if ($user) {
                return back()->with(["success" => "Password Berhasil Diperbarui"]);
            } else {
                return back()->with(["error" => "Password Gagal Diperbarui"]);
            }
        }
    }

    function guruUpdate(Request $request)
    {
        $rules = [
            "email" => "required",
            "contact" => "required",
        ];
        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute terlebih dahulu'
        ];
        $this->validate($request, $rules, $customMessages);

        $object = Guru::find($request->id);
        $object->email = $request->email;
        $object->name = $request->name;
        $object->contact = $request->contact;
        $object->save();

        if ($object) {
            return back()->with(["success" => "Berhasil Mengupdate Data Guru"]);
        } else {
            return back()->with(["error" => "Gagal Mengupdate Data Guru"]);
        }
    }

    function viewAdminManage(Request $request)
    {
        $santri = Santri::all();

        $countSantri = count($santri->all());
        $countAsatidz = Guru::where('deleted_at', '=', null)->count();
        $countSMA = $santri->where('jenjang', '=', 'SMA')->count();

        $widget = [
            "countAsatidz" => $countAsatidz,
            "countSMA" => $countSMA,
            "countSantri" => $countSantri,
        ];

        $data = Guru::select('*')
            ->orderBy('created_at', 'DESC')
            ->where('deleted_at', '=', null);
        if ($request->ajax()) {
            $data = Guru::select('*')
                ->orderBy('created_at', 'DESC')
                ->where('deleted_at', '=', null);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex"><a href="' . url("admin/data/santri/$row->id/edit") . '" id="' . $row->id . '" class="btn d-none btn-primary btn-sm ml-2">Edit</a>';
                    $btn .= '<a href="javascript:void(0)" id="' . $row->id . '" class="btn btn-danger btn-sm ml-2 btn-delete">Delete</a>';
                    $btn .= '<a href="javascript:void(0)" id="' . $row->id . '" class="btn btn-warning btn-sm ml-2 btn-res-pass">Reset Password</a></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.guru.manage')->with(compact('widget'));
    }

    function adminInsert(Request $request)
    {
        $object = new Guru();
        $object->name = $request->name;
        $object->contact = $request->contact;
        $object->email = $request->email;
        $object->password = bcrypt($request->password);

        $object->save();

        $guru = Guru::where('deleted_at', '=', null)->count();
        if ($object) {
            return $guru;
        } else {
            return 0;
        }
    }

    function viewAdminEdit(Request $request, $id)
    {
        $santri = Santri::find($id);
        $classes = DB::select("SELECT kelas from santri GROUP BY kelas");
        $jenjang = DB::select("SELECT jenjang from santri GROUP BY jenjang");
        $asrama = DB::select("SELECT asrama from santri GROUP BY asrama");
        $widget = [
            "santri" => $santri,
            "jenjang" => $jenjang,
            "classes" => $classes,
            "asrama" => $asrama,
        ];

        return view('admin.santri.edit')->with(compact('widget'));
    }

    function resetPassword(Request $request)
    {
        $id = $request->id;
        $object = Guru::findOrFail($id);
        //New Password is AlbinaaIBS
        $object->password = '$2y$12$yEeLQTZtnfT77kjbTSFHJuSCD4g3Q6J1T9ourXCb.T8wpDZerCGW.';
        $object->save();
    }



    function deleteAjax(Request $request)
    {
        $object = Guru::findOrFail($request->id);
        $object->deleted_at = 1;
        $object->delete();

        $guruAll = Guru::where('deleted_at', '=', null)->count();

        if ($object) {
            return $guruAll;
        } else {
            return 0;
        }
    }
}
