<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutabaah extends Model
{
    
    protected $table = "mutabaah";
    use HasFactory;

    public function admin(){
    	return $this->belongsTo(Admin::class,'id');
    }

    public function activity(){
    	return $this->hasMany(Activity::class,'mutabaah_id');
    }

    public function record(){
    	return $this->hasMany(SantriMutabaahRecord::class,'mutabaah_id');
    }

    protected $fillable =[
        "judul","status","tanggal","created_by","deleted_by","deleted_at"
    ];

    


}
