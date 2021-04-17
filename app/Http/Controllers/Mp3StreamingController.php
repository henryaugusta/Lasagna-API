<?php

namespace App\Http\Controllers;

use App\Models\Mp3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class Mp3StreamingController extends Controller
{
    function viewAdminPreview()
    {
        $mp3 = DB::table('mp3s')->get('*');
        $song = [];

        $songDB =  DB::table('mp3s')->get('*');
        
        foreach ($songDB as $key) {

            $song[] =[
                'name' => $key->name,
                'artist' => $key->artist,
                'url' => URL::to('/')."/web_files/mp3/raw/".$key->url,
                'cover' => $key->cover,
            ];
           
        }


        $widget = [
            "mp3" => $mp3,
            "song" => $song,
        ];

        // return $widget;

        return view('admin.mp3.index')->with(compact('widget'));
    }

    function viewSantriPreview()
    {
        $mp3 = DB::table('mp3s')->get('*');
        $song = [];

        $songDB =  DB::table('mp3s')->get('*');
        
        foreach ($songDB as $key) {

            $song[] =[
                'name' => $key->name,
                'artist' => $key->artist,
                'url' => URL::to('/')."/web_files/mp3/raw/".$key->url,
                'cover' => $key->cover,
            ];
           
        }


        $widget = [
            "mp3" => $mp3,
            "song" => $song,
        ];

        // return $widget;

        return view('santri.mp3.index')->with(compact('widget'));
    }


    function store(Request $request)
    {


        $fileMP3 = $request->file('inputFileSongRaw');
        $fileImage = $request->file('inputFileSongImage');

        $extensionMP3 = $fileMP3->getClientOriginalExtension();
        $extensionImage = $fileImage->getClientOriginalExtension();


        $mp3 = new Mp3();

        $bin_pathImage = "/public/web_files/mp3/image/";
        $bin_pathMP3 = "/public/web_files/mp3/raw/";

        $stampMP3 = now()->timestamp.".".$extensionMP3;
        $stampImage = now()->timestamp.".".$extensionImage;

        $saveFileNameMP3 = $bin_pathMP3.$stampMP3;
        $saveFileNameImage = $bin_pathImage.$stampImage;

        $fileImage->move(base_path($bin_pathImage),$saveFileNameImage );
        $fileMP3->move(base_path($bin_pathMP3), $saveFileNameMP3);


        $pathImage = $stampImage;
        $pathMP3 = $stampMP3;
        
        $mp3->name = $request->inputSongName;
        $mp3->artist = $request->inputSongArtist;
        $mp3->url = $pathMP3;
        $mp3->cover = $pathImage;
        $mp3->save();

        if ($mp3) {
            return back()->with(["success"=>"MP3 Berhasil Ditambahkan"]);
        }else{
            return back()->with(["error"=>"MP3 Gagal Ditambahkan"]);
            
        }
    }
}
