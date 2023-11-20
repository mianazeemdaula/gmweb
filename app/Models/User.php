<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function wallet(){
        return $this->hasOne(Wallet::class)->latest();
    }

    public function transactions(){
        return $this->hasMany(Wallet::class);
    }

    public function deposit(){
        return $this->hasOne(Deposit::class)->latest();
    }

    public function deposits(){
        return $this->hasMany(Deposit::class);
    }

    public function withdrawl(){
        return $this->hasOne(Withdrawl::class)->latest();
    }

    public function withdrawls(){
        return $this->hasMany(Withdrawl::class);
    }
    
    public function referrals(){
        return $this->hasMany(User::class, 'referral');
    }
    

    public function referrer(){
        return $this->belongsTo(User::class, 'referral');
    }
}
