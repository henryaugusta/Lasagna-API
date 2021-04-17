<?php

namespace App\Http\Controllers;

use App\Exports\SantriAllExport;
use App\Exports\SantriMutabaahDailyeExport;
use App\Exports\SantriMutabaahDailyExport;
use App\Exports\SantriMutabaahDailyReport;
use App\Models\Mutabaah;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class SantriController extends Controller
{
    function viewAdminManage(Request $request)
    {
        $santri = Santri::all();

        $countSantri = count($santri->all());
        $countSMP = $santri->where('jenjang', '=', 'SMP')->count();
        $countSMA = $santri->where('jenjang', '=', 'SMA')->count();

        $widget = [
            "countSMP" => $countSMP,
            "countSMA" => $countSMA,
            "countSantri" => $countSantri,
        ];

        $data = Santri::select('*')
            ->orderBy('created_at', 'DESC');
        if ($request->ajax()) {
            $data = Santri::select('*')
                ->orderBy('created_at', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex"><a href="' . url("admin/data/santri/$row->id/edit") . '" id="' . $row->id . '" class="btn btn-primary btn-sm ml-2">Edit</a>';
                    $btn .= '<a href="javascript:void(0)" id="' . $row->id . '" class="btn btn-danger btn-sm ml-2 btn-delete">Delete</a>';
                    $btn .= '<a href="javascript:void(0)" id="' . $row->id . '" class="btn btn-warning btn-sm ml-2 btn-res-pass">Reset Password</a></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.santri.manage')->with(compact('widget'));
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

    function santriViewProfile(Request $request)
    {

        $santri = Santri::find(Auth::guard('santri')->id());
        $classes = DB::select("SELECT kelas from santri GROUP BY kelas");
        $jenjang = DB::select("SELECT jenjang from santri GROUP BY jenjang");
        $asrama = DB::select("SELECT asrama from santri GROUP BY asrama");
        $widget = [
            "santri" => $santri,
            "jenjang" => $jenjang,
            "classes" => $classes,
            "asrama" => $asrama,
        ];

        return view('santri.profile')->with(compact('widget'));
    }

    function santriChangePassword(Request $request)
    {
        $this->validate($request, [
            'new_password' => 'required|min:6'
        ]);

        $user = Santri::findOrFail(Auth::guard('santri')->id());
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

    function deleteAjax(Request $request)
    {
        $id = $request->id;
        $santri = Santri::findOrFail($id);
        $santri->delete();

        $santriAll = Santri::all();
        $santriSMP = $santriAll->where('jenjang', '=', 'SMP');
        $santriSMA = $santriAll->where('jenjang', '=', 'SMA');

        $widget = [
            "countSantri" => $santriAll->count(),
            "countSMA" => $santriSMP->count(),
            "countSMP" => $santriSMA->count(),
        ];
        return $widget;
    }


    function resetPassword(Request $request)
    {
        $id = $request->id;
        $santri = Santri::findOrFail($id);
        //New Password is AlbinaaIBS
        $santri->password = '$2y$12$yEeLQTZtnfT77kjbTSFHJuSCD4g3Q6J1T9ourXCb.T8wpDZerCGW.';
        $santri->save();
    }


    function update(Request $request)
    {

        $rules = [
            "id" => "required",
            "nis" => "required",
            "nama" => "required",
            "kelas" => "required",
            "jenjang" => "required",
            "jk" => "required",
            "asrama" => "required",
        ];
        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute terlebih dahulu'
        ];
        $this->validate($request, $rules, $customMessages);

        $object = Santri::find($request->id);


        $object->nis = $request->nis;
        $object->nama = $request->nama;
        $object->kelas = $request->kelas;
        $object->jenjang = $request->jenjang;
        $object->jk = $request->jk;
        $object->asrama = $request->asrama;
        $object->line_id = $request->line_id;
        $object->no_telp = $request->no_telp;

        $object->save();

        if ($object) {
            return back()->with(["success" => "Berhasil Mengupdate Data Santri"]);
        } else {
            return back()->with(["error" => "Gagal Mengupdate Data Santri"]);
        }
    }

    public function laporanExcel(Request $request)
    {
        $santriID = $request->input('santri_id');
        $mutabaahID = $request->input('mutabaah_id');
        $santri = Santri::find($santriID);
        $mutabaah = Mutabaah::find($mutabaahID);



        return Excel::download(
            new SantriMutabaahDailyReport($santriID, $mutabaahID),
            "$mutabaah->judul" . "_" . "$mutabaah->tanggal" . "_$santri->nama" . ".xlsx"
        );
    }



    public function laporanExcelAll(Request $request)
    {
        $rules = [
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'santri_id' => 'required',
        ];
        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute terlebih dahulu',
            'after' => 'Tanggal selesai harus setelah tanggal mulai'
        ];


        $this->validate($request, $rules, $customMessages);

        $santriID = $request->input('santri_id');
        $start = $request->tanggal_mulai;
        $end = $request->tanggal_selesai;
        $santri = Santri::find($santriID);

        return Excel::download(
            new SantriAllExport($santriID, $start, $end),
            "Laporan Mutaba'ah" . "_$santri->nama" . ".xlsx"
        );
    }
}
