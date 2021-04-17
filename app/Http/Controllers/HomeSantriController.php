<?php

namespace App\Http\Controllers;

use App\Models\Mutabaah;
use App\Models\Santri;
use Illuminate\Http\Request;

class HomeSantriController extends Controller
{
    public function index(){

        $santri = Santri::all();
        $mutabaah = Mutabaah::all();

        $countSantri = count($santri->all());
        $countSMP = $santri->where('jenjang','=','SMP')->count();
        $countSMA = $santri->where('jenjang','=','SMA')->count();
        $countAgenda = $mutabaah->where('deleted_at','=',null)->count(); 
        $widget= [
            "santri"=>$santri,
            "countAgenda"=>$countAgenda,
            "countSantri"=>$countSantri,
            "countSMA"=>$countSMA,
            "countSMP"=>$countSMP,
        ];
        return view('santri.dashboard.home')->with(compact('widget'));
    }
}
