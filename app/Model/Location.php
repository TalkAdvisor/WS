<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    public function events()
    {
        return $this->belongsToMany('App\Model\Event')->withTimestamps();
    }

    public function series()
    {
        return $this->belongsToMany('App\Model\Series')->withTimestamps();
    }

    public function cities()
    {
        return $this->belongsTo('App\Model\City');
    }
}
