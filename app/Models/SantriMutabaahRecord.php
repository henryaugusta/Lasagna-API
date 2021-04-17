<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SantriMutabaahRecord extends Model
{
    use HasFactory;
    protected $table = "santri_mutabaah_records";

    //this record belongs to activity
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'id');
    }

    protected $fillable = [
        "id",
        "santri_id",
        "mutabaah_id",
        "activity_id",
        "status",
        "deleted_at",
        "created_at",
        "updated_at"
    ];
}
