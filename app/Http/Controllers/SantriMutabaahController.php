<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Mutabaah;
use App\Models\SantriMutabaahRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SantriMutabaahController extends Controller
{
    function viewSantriInit()
    {
        $santriID = Auth::guard('santri')->id();

        $mutabaah = Mutabaah::all()
            ->where('deleted_at', '=', null)
            ->sortByDesc('tanggal')->all();

        $mutabaahProcessed = $this->getMutabaahRecord($santriID);

        $widget = [
            "mutabaah" => $mutabaah,
            "mutabaahProcessed" => $mutabaahProcessed,
        ];

        return view('santri.mutabaah.init')->with(compact(['widget']));
    }

    function viewSantriReport()
    {
        $santriID = Auth::guard('santri')->id();

        $mutabaah = Mutabaah::all()
            ->where('deleted_at', '=', null)
            ->sortByDesc('tanggal')->all();

        $mutabaahProcessed = $this->getMutabaahRecord($santriID);

        $widget = [
            "mutabaah" => $mutabaah,
            "mutabaahProcessed" => $mutabaahProcessed,
        ];
        return view('santri.mutabaah.report')->with(compact(['widget']));
    }

    function getMutabaahRecord($santriID)
    {
        $mutabaah = Mutabaah::all()
            ->where('deleted_at', '=', null)
            ->sortByDesc('tanggal')->all();

        $mutabaahProcessed = array();
        foreach ($mutabaah as $key) {

            $inputed = 0;
            $exist = DB::table('santri_mutabaah_records')
                ->where('santri_id', '=', $santriID)
                ->where('mutabaah_id', '=', $key['id'])
                ->count();

            //Check if santri already fill this mutaba'ah
            if ($exist > 0) {
                $inputed = 1;
            }

            $mutabaahProcessed[] = [
                "id" => $key['id'],
                "judul" => $key['judul'],
                "status" => $key['status'],
                "tanggal" => $key['tanggal'],
                "inputed" => $inputed,
                "deleted_by" => $key['deleted_by'],
                "deleted_at" => $key['deleted_at'],
                "created_at" => $key['created_at'],
                "updated_at" => $key['updated_at'],
            ];
        }

        return $mutabaahProcessed;
    }

    function input($id)
    {
        $santriID = Auth::guard('santri')->id();
        $exist = DB::table('santri_mutabaah_records')
            ->where('santri_id', '=', $santriID)
            ->where('mutabaah_id', '=', $id)
            ->count();

        //Check if santri already fill this mutaba'ah
        if ($exist > 0) {
            return redirect('/santri/mutabaah/input')->with(["success" => "Lembar Mutabaah Sudah Diisi"]);
        }


        $mutabaah = Mutabaah::all()->sortByDesc('tanggal');
        $mutabaahCurrent = Mutabaah::where('id', '=', $id)->first();
        $activity = Activity::where('mutabaah_id', '=', $id)->get();

        if ($mutabaahCurrent->status != 1) {
            return back()->with(["error" => "Lembar Mutaba'ah Ini Sudah Ditutup"]);
        } else {

            $widget = [
                "mutabaah" => $mutabaah,
                "mutabaahCurrent" => $mutabaahCurrent,
                "activity" => $activity,
            ];

            return view('santri.mutabaah.input')->with(compact('widget'));
        }
    }

    function store(Request $request, $id)
    {

        foreach ($request->activity as $item => $value) {
            $object = new SantriMutabaahRecord();
            $object->mutabaah_id = $request->mutabaah_id;
            $object->santri_id = $request->santri_id;

            // dd($request->all());

            $object->activity_id = $item;

            if ($value == "on") {
                $object->status = "1";
            } else {
                $object->status = "0";
            }

            $object->save();
        }

        return back()->with(["success" => "Berhasil Menginput Mutaba'ah"]);
    }


    function viewMutabaahReport($id)
    {
        $santriID = $this->getSantriID();
        $mutabaah = Mutabaah::where('id', '=', $id)->first();

        $recordMutabaah = array();

        $recordMutabaahR = SantriMutabaahRecord::where('santri_id', '=', $santriID)
            ->where('mutabaah_id', '=', $id)->get();

        foreach ($recordMutabaahR as $key) {
            $act = Activity::findOrFail($key['activity_id']);
            $recordMutabaah[] = [
                "id" => $key['id'],
                "mutabaah_id" => $key['mutabaah_id'],
                "poin" => $act['poin'],
                "status" => $key['status'],
                "activityName" => $act->nama_kegiatan,
            ];
        }

        $widget = [
            "mutabaah" => $mutabaah,
            "recordMutabaah" => $recordMutabaah
        ];

        return view('santri.mutabaah.report_detail')
            ->with(compact('widget'));
    }

    function viewSantriReportAll(Request $request)
    {
        $start = null;
        $end = null;

        $santriID = $this->getSantriID();
        $mutabaah = Mutabaah::all();
        $recordMutabaah = SantriMutabaahRecord::where('santri_id', '=', $santriID);
        $recordMutabaahFirst = SantriMutabaahRecord::where('santri_id', '=', $santriID)->first();
        $recordMutabaahFirstID = $recordMutabaahFirst->mutabaah_id;

        
        $activityDetail = array();
        $activity = Activity::where('mutabaah_id', '=', $recordMutabaahFirstID)->get();
        if ($request->has('start')) {
         
            $rules = [
                'start' => 'required|date',
                'end' => 'required|date',
            ];
            $customMessages = [
                'required' => 'Mohon Isi Kolom :attribute terlebih dahulu',
                'after' => 'Tanggal selesai harus setelah tanggal mulai'
            ];

        
            $this->validate($request, $rules, $customMessages);

            $from = $request->start;
            $to = $request->end;
            $start = $from;
            $end = $to;

            $mutabaah = Mutabaah::whereBetween('tanggal', [$from, $to])->get();


            if ($mutabaah->count() < 1) {
                $activity = Activity::where('mutabaah_id', '=', 0)->get();
                // return redirect('santri/mutabaah/report/all')->with(["error"=>"Tidak Ada Mutabaah Pada Tanggal Tersebut"]);
            }
        }

        foreach ($mutabaah as $key) {
            $record = SantriMutabaahRecord::where('santri_id', '=', $santriID);
            $activityDetail[$key->id] = $record->where('mutabaah_id', '=', $key->id)->get();
        }


        $widget = [
            "activity" => $activity,
            "activityScore" => $activityDetail,
            "mutabaah" => $mutabaah,
            "recordMutabaah" => $recordMutabaah->get(),
            "start" => $start,
            "end" => $end,
        ];

        return $widget;


        return view('santri.mutabaah.report_all')
            ->with(compact('widget'));
    }


    function getSantriID()
    {
        $santriID = 0;
        if (Auth::guard('santri')->check()) {
            $santriID = Auth::guard('santri')->id();
        }

        return $santriID;
    }
}
