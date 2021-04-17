<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokTahfidz extends Model
{
    protected $table = "kelompok_tahfidz";
    protected $fillable = ["name","maker","url_file","url_img","deleted_at"];
    use HasFactory;
}
