<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mining extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'ref_amount',
        'mining_end',
    ];

    protected $casts = [
        'mining_end' => 'datetime',
        'amount' => 'float',
        'ref_amount' => 'float',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
