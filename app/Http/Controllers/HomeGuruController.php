<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeGuruController extends Controller
{
    function index(){
        return view('guru.dashboard.home');
    }
}
