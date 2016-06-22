<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    //
    public function speakers()
    {
        return $this->belongsToMany('App\Model\Speaker');
    }

    public function reviews()
    {
        return $this->hasMany('App\Model\Review');
    }

    public function event()
    {
        return $this->belongsTo('App\Model\Event');
    }
}
