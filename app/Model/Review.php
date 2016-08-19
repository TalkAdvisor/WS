<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    public function review_options()
    {
        return $this->belongsToMany('App\Model\ReviewOption', 'review_ratingoption', 
      'review_id', 'ratingoption_id')->withPivot('score')->withTimestamps();
    }

    public function talk()
    {
        return $this->belongsTo('App\Model\Talk');
    }

    public function speaker()
    {
        return $this->belongsTo('App\Model\Speaker');
    }

     public function user()
    {
        return $this->belongsTo('App\User');
    }
}
