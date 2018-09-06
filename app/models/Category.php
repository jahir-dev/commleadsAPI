<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The offer belongs to one buyer
     */
    public function parentCategory()
    {
        return $this->belongsTo(ParentCategory::class,'parentCat_id');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}
