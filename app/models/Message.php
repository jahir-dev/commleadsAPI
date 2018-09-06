<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function to()
    {
        return $this->belongsTo(Offer::class);
    }

    public function from()
    {
        return $this->belongsTo(Offer::class);
    }

}
