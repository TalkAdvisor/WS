<?php

namespace App\Http\Controllers\Speaker;


use View;
use Session;
use Storage;
use File;
use Illuminate\Http\Request;
use App\Model\Speaker;
use App\Model\Review;
use App\Http\Controllers\Controller;
use App\Http\Requests\SpeakerFormRequest;
use Illuminate\Contracts\Filesystem\Filesystem;


class SpeakerController extends Controller
{
    public function index()
    {
        $speakers = Speaker::all();
        return $this->response->array(['speakers' => $speakers->toArray()]);
    }

    public function getMaxRating($count)
    {
        $speakers = Speaker::orderBy('average_1', 'desc')->take($count)->get();
        return $this->response->array(['speakers' => $speakers->toArray()]);
    }

    public function getSpeaker($id)
    {
        $speaker = Speaker::findOrFail($id);
        return $this->response->array(['speaker' => $speaker->toArray()]);
    }

    public function getReview($id)
    {
        $speaker = Speaker::findOrFail($id);
        $reviews = Review::where('speaker_id', '=', $speaker->id)->get();
        $review_with_rating = array();
        $review_data = array();
        foreach($reviews as $review){
          $review_with_rating['review'] = $review;
          $review_with_rating['review_rating'] = $review->review_options()->get();
          $review_data[] = $review_with_rating;
        }
        return $this->response->array(['speaker' => $speaker->toArray(), 'reviews' => $review_data]);
    }

    public function getLastReview($id, $count)
    {
        $speaker = Speaker::findOrFail($id);
        $reviews = Review::where('speaker_id', '=', $speaker->id)->orderBy('id', 'desc')->take($count)->get();
        $review_with_rating = array();
        $review_data = array();
        foreach($reviews as $review){
          $review_with_rating['review'] = $review;
          $review_with_rating['review_rating'] = $review->review_options()->get();
          $review_data[] = $review_with_rating;
        }
        return $this->response->array(['speaker' => $speaker->toArray(), 'reviews' => $review_data]);
    }

    public function getQuote($id, $count)
    {
        $speaker = Speaker::findOrFail($id);
        $reviews = Review::where('speaker_id', '=', $speaker->id)->orderByRaw('RAND()')->take($count)->get();
        foreach($reviews as $review){
          $quote[] = $review->quote;
        }
        return $this->response->array(['speaker' => $speaker->toArray(), 'quotes' => $quote]);
    }

    public function store(Request $request)
    {
        try{
	        $speaker = new Speaker;
	        $speaker->speaker_name = $request->input('speaker_name');
	        $speaker->speaker_englishname = $request->input('speaker_englishname');
	        $speaker->speaker_company = $request->input('speaker_company');
	        $speaker->speaker_title = $request->input('speaker_title');
	        $speaker->speaker_description = $request->input('speaker_description');
          $speaker->average_1 = $request->input('average_1');
          $speaker->average_2 = $request->input('average_2');
          $speaker->average_3 = $request->input('average_3');
          $speaker->average_4 = $request->input('average_4');
          $speaker->average_5 = $request->input('average_5');
          $average_array = [
            $request->input('average_1'),
            $request->input('average_2'),
            $request->input('average_3'),
            $request->input('average_4'),
            $request->input('average_5'),
          ];
          $average = array_sum($average_array) / count($average_array);
          $speaker->number_reviews = $average;
	        $speaker->speaker_email = $request->input('speaker_email');
          $speaker->video = $request->input('speaker_video');
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

    public function update(Request $request, $id)
    {
        try{
          $s3 = Storage::disk('s3');
          $speaker = Speaker::find($id);
          $speaker->speaker_name = $request->input('speaker_name');
          $speaker->speaker_englishname = $request->input('speaker_englishname');
          $speaker->speaker_company = $request->input('speaker_company');
          $speaker->speaker_title = $request->input('speaker_title');
          $speaker->average_1 = $request->input('average_1');
          $speaker->average_2 = $request->input('average_2');
          $speaker->average_3 = $request->input('average_3');
          $speaker->average_4 = $request->input('average_4');
          $speaker->average_5 = $request->input('average_5');
          $average_array = [
            $request->input('average_1'),
            $request->input('average_2'),
            $request->input('average_3'),
            $request->input('average_4'),
            $request->input('average_5'),
          ];
          $average = array_sum($average_array) / count($average_array);
          $speaker->number_reviews = $average;
          $speaker->speaker_description = $request->input('speaker_description');
          $speaker->speaker_email = $request->input('speaker_email');
          $speaker->video = $request->input('speaker_video');
          $file = $request->file('image');
          if($file != null){
              //upload image to server and s3
              $image_name = time()."-".$file->getClientOriginalName();
              $file->move('uploads/speakers/', $image_name);
              $speaker->local_path = 'uploads/speakers/'.$image_name;
              $s3->put('speakers/'.$image_name, file_get_contents($speaker->local_path));
              //delete old image
              $s3->delete('speakers/'.$speaker->speaker_photo);
              File::delete('uploads/speakers/'.$speaker->speaker_photo);
              $speaker->speaker_photo = $image_name;
          }
          $speaker->save();
          return $this->response->array($speaker->toArray());
        }
        catch(\Exception $e){
           // do task when error
           return $this->response->error($e->getMessage(), 500);
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
