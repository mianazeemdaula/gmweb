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
        'reward_price',
        'reward_type',
        'start_date',
        'end_date',
        'active',
        'qty',
        'qty_sold',
        'image',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'offer_users')->withPivot(['price'])->withTimestamps();
    }
}
