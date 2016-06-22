<?php

namespace App\Http\Controllers\Speaker;


use View;
use Session;

use Illuminate\Http\Request;
use App\Model\Speaker;
use App\Http\Controllers\Controller;
use App\Http\Requests\SpeakerFormRequest;

class SpeakerController extends Controller
{
    public function index()
    {
        $speaker = Speaker::all();
        return $this->response->array($speaker->toArray());
    }

    public function getSpeaker($id)
    {
        $speaker = Speaker::findOrFail($id);
        return $this->response->array($speaker->toArray());
    }

    public function store(Request $request)
    {
        try{
	        $speaker = new Speaker;
	        $speaker->speaker_name = $request->input('speaker_name');
	        $speaker->speaker_englishname = $request->input('speaker_englishname');
	        $speaker->speaker_company = $request->input('speaker_company');
	        $speaker->speaker_title = $request->input('speaker_title');
	        $speaker->speaker_language = $request->input('speaker_language');
	        $speaker->speaker_description = $request->input('speaker_description');
	        $speaker->speaker_email = $request->input('speaker_email');
	        $file = $request->file('image');
	        if($file != null){
	            $image_name = time()."-".$file->getClientOriginalName();
	            $file->move('uploads/speakers/', $image_name);
	            $speaker->speaker_photo = $image_name;
	            $speaker->local_path = 'uploads/speakers/'.$image_name;
	        }
	        $speaker->save();
          return $this->response->array($speaker->toArray());
        }
        catch(\Exception $e){
           // do task when error
           return $this->response->error($e->getMessage(), 500);
        }
    }

    public function update($request, $id)
    {
        try{
	        $speaker = Speaker::find($id);
	        $speaker->speaker_name = $request->input('speaker-name');
	        $speaker->speaker_englishname = $request->input('speaker-en-name');
	        $speaker->speaker_company = $request->input('speaker-company');
	        $speaker->speaker_title = $request->input('speaker-title');
	        $speaker->speaker_language = $request->input('speaker-lang');
	        $speaker->speaker_description = $request->input('speaker-description');
	        $speaker->speaker_email = $request->input('speaker-email');
	        $file = $request->file('image');
	        if($file != null){
	            $image_name = time()."-".$file->getClientOriginalName();
	            $file->move('uploads/speakers/', $image_name);
	            $speaker->speaker_photo = $image_name;
	            $speaker->local_path = 'uploads/speakers/'.$image_name;
	        }
	        $speaker->save();
	        return array(
           		'status' => true,
           		'speaker' => $speaker,
           		'message' => 'Update Speaker '.$speaker->speaker_name.' Successful'
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
        	$speaker = Speaker::find($id);
	        $speaker->delete();
	        
	        return array(
           		'status' => true,
           		'speaker' => $speaker,
           		'message' => 'Delete Speaker '.$speaker->speaker_name.' Successful'
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
