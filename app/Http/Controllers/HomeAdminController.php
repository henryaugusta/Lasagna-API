<?php

namespace App\Http\Controllers;

use App\Models\Mutabaah;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeAdminController extends Controller
{
    public function index(){

        $widget= [
        ];
        // return $widget;
        return view('admin.dashboard.home')->with(compact('widget'));
    }
}
