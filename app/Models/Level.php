<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'description',
        'min_price',
        'max_price',
        'return_percentage',
        'active',
    ];
}
