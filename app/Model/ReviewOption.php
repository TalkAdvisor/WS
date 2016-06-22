<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ReviewOption extends Model
{
    //
    public function reviews()
    {
        return $this->belongsToMany('App\Model\Review');
    }
}
