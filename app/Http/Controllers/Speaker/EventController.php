<?php

namespace App\Http\Controllers\Speaker;


use View;
use Session;

use Illuminate\Http\Request;
use App\Model\Event;
use App\Model\Series;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function index()
    {
        $event = Event::all();
        return $event;
    }

    public function getEvent($id)
    {
        $event = Event::find($id);
        return $event;
    }

    public function getEventDetail($id)
    {
        $event = Event::find($id);
        $locations = $event->locations()->get();
        $organizers = $event->organizers()->get();
        $data = array(
          'event' => $event,
          'locations' => $locations,
          'organizers' => $organizers
        );
        return $data;
    }

    public function getSeriesDetail($id)
    {
        $series = Series::find($id);
        $series->events;
        $locations = $series->locations()->get();
        $organizers = $series->organizers()->get();
        $data = array(
          'series' => $series,
          'locations' => $locations,
          'organizers' => $organizers
        );
        return $data;
    }

    public function getLocations($id)
    {
        $event = Event::find($id);
        $locations = $event->locations()->get();
        return $locations;
    }

    public function store($request)
    {
        try{
	        $event = new Event;
	        $event->topic =  $request->input('topic');
	        $event->event =  $request->input('event');
	        $event->event_series =  $request->input('series');
	        $event->start_date =  $request->input('date');
	        $event->event_city =  $request->input('city');
	        $event->extend_city =  $request->input('city-field');
	        $event->event_location =  $request->input('location');
	        $event->extend_location =  $request->input('location-field');
	        $event->organizer =  implode('|',$request->input('organizer'));
	        $event->extend_organizer =  $request->input('organizer-field');
	        $event->speaker_quote =  $request->input('quote');
	        //$event->speaker_id =  $request->input('speaker_id');
	        $event->save();
	        $speakersId = $request->input('speaker-id');
	        foreach($speakersId as $id){
	        	if($id != ''){
	        		$event->speakers()->attach($id);
	        	}
	        }
	        //$event->speakers()->attach($request->input('speaker-id'));
	        return array(
           		'status' => true,
           		'event' => $event,
           		'message' => 'Create Event '.$event->topic.' Successful'
           	);
        }
        catch(\Exception $e){
           // do task when error
           return array(
           		'status' => false,
           		'message' => $e->getMessage()
           	);   // insert query
        }
    }

    public function update($request, $id)
    {
        try{
	        $event = Event::find($id);
	        $event->event_name = $request->input('event-name');
	        $event->event_englishname = $request->input('event-en-name');
	        $event->event_company = $request->input('event-company');
	        $event->event_title = $request->input('event-title');
	        $event->event_language = $request->input('event-lang');
	        $event->event_description = $request->input('event-description');
	        $event->event_email = $request->input('event-email');
	        $file = $request->file('image');
	        if($file != null){
	            $image_name = time()."-".$file->getClientOriginalName();
	            $file->move('uploads/events/', $image_name);
	            $event->event_photo = $image_name;
	            $event->local_path = 'uploads/events/'.$image_name;
	        }
	        $event->save();
	        return array(
           		'status' => true,
           		'event' => $event,
           		'message' => 'Update Event '.$event->event_name.' Successful'
           	);
        }
        catch(\Exception $e){
           // do task when error
           return array(
           		'status' => false,
           		'message' => $e->getMessage()
           	);   // insert query
        }
    }

    public function delete($id)
    {
        try{
        	$event = Event::find($id);
	        $event->delete();
	        
	        return array(
           		'status' => true,
           		'event' => $event,
           		'message' => 'Delete Event '.$event->event_name.' Successful'
           	);
        }
        catch(\Exception $e){
           // do task when error
           return array(
           		'status' => false,
           		'message' => $e->getMessage()
           	);   // insert query
        }
    }
}
