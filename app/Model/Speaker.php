<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    //
    /*public function events()
    {
        return $this->hasMany('App\Model\Event');
    }*/

    public function talks()
    {
        return $this->belongsToMany('App\Model\Talk')->withTimestamps();
    }
}
