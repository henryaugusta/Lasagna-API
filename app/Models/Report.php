<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = "reports";

    protected $fillable = [
        "id",
        "no_laporan",
        "detail_kejadian",
        "detail_alamat",
        "lat",
        "long",
        "photo_path",
        "status",
        "status_desc",
        "is_public",
        "id_staff",
        "id_people",
        "id_category",
        "created_at",
        "updated_at",
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:00',
        'updated_at' => 'datetime:Y-m-d H:00',
    ];

    protected $appends = ['status_label', 'people', 'category', 'staff'];

    function getPeopleAttribute()
    {
        return People::find($this->id_people);
    }
    function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case '0':
                return "Belum Diproses";
                break;

            case '1':
                return "Koordinasi Pihak Terkait";
                break;

            case '2':
                return "Diproses Pihak Terkait";
                break;

            case '3':
                return "Selesai";
                break;

            case '4':
                return "Ditolak";
                break;

            default:
                return "Tidak Diketahui";
                break;
        }

        return People::find($this->id_people);
    }

    function getStaffAttribute()
    {
        return Admin::find($this->id_staff);
    }

    function getCategoryAttribute()
    {
        return ReportCategory::find($this->id_category);
    }
}
