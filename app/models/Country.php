<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function buyers()
    {
        $this->hasMany(Buyer::class);
    }
}
