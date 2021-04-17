<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    function viewDetail($id)
    {
        $group = DB::select("SELECT a.* , b.name as `g_name`, b.id as `g_id`, b.contact as `g_contact` ,
         b.email as `g_email` from kelompok_tahfidz a left join guru b  on a.mentor_id=b.id where a.id='$id'");
        $member = Santri::where('group_id','=',$id)->get();

        $widget = [
            "group" => $group[0],
            "member" => $member
        ];


        return view('group.detail')->with(compact('widget'));
    }
    
}
