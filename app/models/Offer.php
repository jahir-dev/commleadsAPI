<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    /**
     * The offer belongs to one buyer
     */
    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
