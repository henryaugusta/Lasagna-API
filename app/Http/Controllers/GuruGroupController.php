<?php

namespace App\Http\Controllers;

use App\Models\KelompokTahfidz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\TextUI\XmlConfiguration\Group;

class GuruGroupController extends Controller
{
    function init(){
        $group = KelompokTahfidz::where('mentor_id','=',Auth::guard('guru')->id())->get();
        return view('guru.group.init')->with(compact('group'));
    }
}
