<?php

namespace App\Http\Controllers\Speaker;


use View;
use Session;

use Illuminate\Http\Request;
use App\Model\Location;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function index()
    {
        $location = Location::all();
        return $location;
    }

    public function getLocation($id)
    {
        $location = Location::find($id);
        return $location;
    }
}
