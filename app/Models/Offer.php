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
        'min_price',
        'max_price',
        'reward_price',
        'reward_type',
        'start_date',
        'end_date',
        'active',
        'qty',
        'qty_sold',
        'image',
        'sort_index',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'active' => 'boolean',
        'qty' => 'integer',
        'qty_sold' => 'integer',
        'reward_price' => 'float',
        'min_price' => 'float',
        'max_price' => 'float',
        'sort_index' => 'integer',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'offer_users')->withPivot(['price'])->withTimestamps();
    }
}
