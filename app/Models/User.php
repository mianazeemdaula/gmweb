<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use TransactionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'image',
        'tag',
        'phone',
        'phone_verified_at',
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

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset("users/$value"),
        );
    }

    public function level(){
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function wallet(){
        return $this->hasOne(Wallet::class)->orderBy('id');
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

    public function paidReferrals(){
        return $this->hasMany(User::class, 'referral')
        ->whereHas('deposit', function($query){
            $query->orWhere('status', 'completed');
        });
    }

    public function referrer(){
        return $this->belongsTo(User::class, 'referral');
    }

    public function offers(){
        return $this->belongsToMany(Offer::class, 'offer_users')->withPivot(['price'])->withTimestamps();
    }
}
