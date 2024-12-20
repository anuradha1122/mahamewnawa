<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'followerId',
        'addressLine1',
        'addressLine2',
        'addressLine3',
        'districtId',
        'monasteryId',
        'mobile1',
        'mobile2',
        'active',
    ];
}
