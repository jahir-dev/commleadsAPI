<?php

namespace App\models;

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Buyer extends Authenticatable implements JWTSubject
{
    use Notifiable;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'firstname', 'lastname', 'address', 'phone'
    ];

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    /**
     * The buyer has many offers
     */
    public function offers()
    {
        return $this->hasMany('App\Offer');
    }

    public function sent()
    {
        return $this->hasMany(Message::class, 'to_buyer');
    }

    public function received()
    {
        return $this->hasMany(Message::class, 'from_buyer');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
