<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SantriMutabaahRecordView extends Model
{
    //THIS MODEL IS READ ONLY !!!!

    use HasFactory;
    protected $table = "view_santri_mutabaah_records";


    protected $fillable = [
        "id",
        "santri_id",
        "mutabaah_id",
        "activity_id",
        "status",
        "nama",
        "kelas",
        "nis",
        "asrama",
        "deleted_at",
        "created_at",
        "updated_at"
    ];
}
