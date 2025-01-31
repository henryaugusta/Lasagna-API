<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyNfcCard extends Model
{
    use HasFactory;
    protected $fillable=[
        "added_by",
        "card_id",
        "label"
    ];
}
