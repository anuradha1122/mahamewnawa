<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DambadiwaCrew extends Model
{
    use HasFactory;

    protected $fillable = [
        'crewId',
        'categoryId',
        'projectId',
        'active',
    ];
}
