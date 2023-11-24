<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_method_id',
        'amount',
        'status',
        'tx_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function payment_method(){
        return $this->belongsTo(PaymentMethod::class);
    }
}
