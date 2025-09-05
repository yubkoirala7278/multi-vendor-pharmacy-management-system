<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'db_name',
        'db_user',
        'db_password',
        'admin_email',
        'admin_password',
    ];

    protected $hidden = [
        'db_password',
        'admin_password',
    ];
}
