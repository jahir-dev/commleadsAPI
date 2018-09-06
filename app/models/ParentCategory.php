<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ParentCategory extends Model
{
    /**
     * The ParentCategory has many categories
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
