<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function fetchAll(){
        $news = News::all();
        $newsCount = $news->count();
        return response()->json([
            'http_response' => 200,
            'status' => 1, 
            'size' => $newsCount,
            'news' => $news, 
            'message_id' => 'Berhasil Fetch Berita',
            'message' => '',
        ]);
    }

}
