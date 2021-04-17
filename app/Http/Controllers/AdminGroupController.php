<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\KelompokTahfidz;
use App\Models\Santri;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AdminGroupController extends Controller
{
    function viewAdminCreate()
    {
        $santri = Santri::where('group_id', '=', null)->get();
        $guru = Guru::all('*');
        $widget = [
            "santri" => $santri,
            "guru" => $guru,
        ];
        return view('admin.group.create')->with(compact('widget'));
    }

    function viewAdminManage()
    {
        $group = DB::select("SELECT a.* , b.name as `g_name`, b.id as `g_id`, b.contact as `g_contact` , b.email as `g_email` from kelompok_tahfidz a left join guru b  on a.mentor_id=b.id");
        $groupCount = KelompokTahfidz::all()->count();
        $mentor = Guru::all();
        $mentorCount = $mentor->count();
        $widget = [
            "group" => $group,
            "guru" => $mentor,
            "countGuru" => $mentorCount,
            "countGroup" => $groupCount,
        ];

        return view('admin.group.manage')->with(compact('widget'));
    }

    function changeMentor(Request $request){
        $object = KelompokTahfidz::findOrFail($request->group_id);
        $object->mentor_id=$request->mentor_id;
        $object->save();

        if ($object) {
            return back()->with(["success"=>"Berhasil Mengubah Pembimbing Kelompok"]);
        }else{
            return back()->with(["failed"=>"Gagal Mengubah Pembimbing Kelompok"]);
        }
    }

    function delete(Request $request)
    {
        $id = $request->id;
        $object = KelompokTahfidz::findOrFail($id);
        $object->delete();

        $countGroup = KelompokTahfidz::all()->count();
        $countGuru = Guru::all()->count();
        
        if ($object) {
            return back()->with(["success"=>"Berhasil Menghapus Anggota Kelompok"]);
        }else{
            return back()->with(["failed"=>"Gagal Menghapus Kelompok"]);
        }
    }


    function store(Request $request)
    {

        //Check if name already in use;
        $check = KelompokTahfidz::where('nama_kelompok', '=', $request->name)->count();
        if ($check != 0) {
            return back()->with(["error" => "Nama Kelompok Sudah Digunakan Kelompok Lain"]);
        }


        $object = new KelompokTahfidz();
        $object->nama_kelompok = $request->name;
        $object->mentor_id = $request->guru;
        $object->save();


        $member = $request->member;
        for ($i = 0; $i < count($member); $i++) {
            $santri = Santri::findOrFail($member[$i]);
            $santri->group_id = $object->id;
            $santri->save();
        }
        if ($object == true && $santri == true) {
            return back()->with(["success" => "Kelompok Berhasil Ditambahkan"]);
        } else {
            return back()->with(["error" => "Kelompok Gagal Ditambahkan"]);
        }
    }
}
