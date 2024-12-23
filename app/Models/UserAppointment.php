<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAppointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'monasteryId',
        'appointedDate',
        'releasedDate',
        'current',
        'active',
    ];
}
