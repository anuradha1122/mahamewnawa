<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserContactInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'addressLine1',
        'addressLine2',
        'addressLine3',
        'mobile1',
        'mobile2',
        'active',
    ];
}
