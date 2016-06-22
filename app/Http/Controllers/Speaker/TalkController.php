<?php

namespace App\Http\Controllers\Speaker;


use View;
use Session;

use Illuminate\Http\Request;
use App\Model\Talk;
use App\Http\Controllers\Controller;
use App\Http\Requests\TalkFormRequest;

class TalkController extends Controller
{
    public function index()
    {
        $talk = Talk::all();
        return $talk;
    }

    public function getTalk($id)
    {
        $talk = Talk::find($id);
        return $talk;
    }

    public function store(TalkFormRequest $request)
    {
        try{
	        $talk = new Talk;
	        $talk->topic =  $request->input('topic');
	        $talk->event =  $request->input('event');
	        $talk->event_series =  $request->input('series');
	        $talk->start_date =  $request->input('date');
	        $talk->talk_city =  $request->input('city');
	        $talk->extend_city =  $request->input('city-field');
	        $talk->talk_location =  $request->input('location');
	        $talk->extend_location =  $request->input('location-field');
	        $talk->organizer =  implode('|',$request->input('organizer'));
	        $talk->extend_organizer =  $request->input('organizer-field');
	        $talk->speaker_quote =  $request->input('quote');
	        //$talk->speaker_id =  $request->input('speaker_id');
	        $talk->save();
	        $speakersId = $request->input('speaker-id');
	        foreach($speakersId as $id){
	        	if($id != ''){
	        		$talk->speakers()->attach($id);
	        	}
	        }
	        //$talk->speakers()->attach($request->input('speaker-id'));
	        return array(
           		'status' => true,
           		'talk' => $talk,
           		'message' => 'Create Talk '.$talk->topic.' Successful'
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
	        $talk = Talk::find($id);
	        $talk->talk_name = $request->input('talk-name');
	        $talk->talk_englishname = $request->input('talk-en-name');
	        $talk->talk_company = $request->input('talk-company');
	        $talk->talk_title = $request->input('talk-title');
	        $talk->talk_language = $request->input('talk-lang');
	        $talk->talk_description = $request->input('talk-description');
	        $talk->talk_email = $request->input('talk-email');
	        $file = $request->file('image');
	        if($file != null){
	            $image_name = time()."-".$file->getClientOriginalName();
	            $file->move('uploads/talks/', $image_name);
	            $talk->talk_photo = $image_name;
	            $talk->local_path = 'uploads/talks/'.$image_name;
	        }
	        $talk->save();
	        return array(
           		'status' => true,
           		'talk' => $talk,
           		'message' => 'Update Talk '.$talk->talk_name.' Successful'
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
        	$talk = Talk::find($id);
	        $talk->delete();
	        
	        return array(
           		'status' => true,
           		'talk' => $talk,
           		'message' => 'Delete Talk '.$talk->talk_name.' Successful'
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
