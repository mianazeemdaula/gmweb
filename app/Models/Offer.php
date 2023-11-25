<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'offer_type',
        'price',
        'reward_price',
        'reward_type',
        'start_date',
        'end_date',
        'active',
        'qty',
        'qty_sold',
        'image',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'active' => 'boolean',
        'qty' => 'integer',
        'qty_sold' => 'integer',
        'reward_price' => 'float',
        'price' => 'float',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'offer_users')->withPivot(['price'])->withTimestamps();
    }
}
