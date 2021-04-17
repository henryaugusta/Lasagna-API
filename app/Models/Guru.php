<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Guru extends Authenticatable

{
    protected $table = "guru";
    use HasFactory;

    protected $fillable = [
        'name',
        'contact',
        'photo_path',
        'email',
        'email_verified_at',
        'password',
        'deleted_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];




}
