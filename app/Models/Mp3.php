<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mp3 extends Model
{
    use HasFactory;
    
    protected $fillable = ["name","maker","url_file","url_img","deleted_at"];
    
}
