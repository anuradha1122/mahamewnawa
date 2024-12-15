<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointmentId',
        'positionId',
        'positionedDate',
        'releasedDate',
        'current',
        'active',
    ];
}
