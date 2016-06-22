<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    //

    public function events()
    {
        return $this->hasMany('App\Model\Event');
    }

    public function locations()
    {
        return $this->belongsToMany('App\Model\Location','series_location','series_id','location_id')->withTimestamps();
    }

    public function organizers()
    {
        return $this->belongsToMany('App\Model\Organizer','series_organizer','series_id','organizer_id')->withTimestamps();
    }
}
