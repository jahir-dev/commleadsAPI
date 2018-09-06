<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
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
