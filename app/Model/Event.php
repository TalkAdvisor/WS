<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //

    public function talks()
    {
        return $this->hasMany('App\Model\Talk');
    }

    public function locations()
    {
        return $this->belongsToMany('App\Model\Location')->withTimestamps();
    }

    public function organizers()
    {
        return $this->belongsToMany('App\Model\Organizer')->withTimestamps();
    }

    public function series()
    {
        return $this->belongsTo('App\Model\Series');
    }
}
