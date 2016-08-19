<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ReviewOption extends Model
{
    //
    protected $table = 'ratingoptions';
    
    public function reviews()
    {
        return $this->belongsToMany('App\Model\Review');
    }
}
