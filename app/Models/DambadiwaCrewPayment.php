<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DambadiwaCrewPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'crewId',
        'categoryId',
        'nic',
        'payment_method',
        'amount',
        'reciptImage',
        'reciptNo',
        'addedDate',
        'confirmedId',
        'confirmedDate',
        'active',
    ];
}
