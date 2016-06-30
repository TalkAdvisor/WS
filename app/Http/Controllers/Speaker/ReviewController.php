<?php

namespace App\Http\Controllers\Speaker;


use View;
use Session;

use Illuminate\Http\Request;
use App\Model\Review;
use App\Model\ReviewOption;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::all();
        $review_with_rating = array();
        $review_data = array();
        foreach($reviews as $review){
        	$review_with_rating['review'] = $review;
	        $review_with_rating['review_rating'] = $review->review_options()->get();
	        $review_data[] = $review_with_rating;
	    }
        return $this->response->array(['reviews' => $review_data]);

    }

    public function getReview($id)
    {
        $review = Review::findOrFail($id);
        $review_rating = $review->review_options()->get();
        return $this->response->array(['review' => $review->toArray(), 'review_rating' => $review_rating->toArray()]);
    }

    public function store(Request $request)
    {
        try{
	        $review = new Review;
	        $review_ratings = ReviewOption::all();
	        $score = $request->input('score');
	        if(count($score)<5) return $this->response->error('Score count is less than 5', 500);
	        $review->user_name = $request->input('user_name');
	        $review->user_email = $request->input('user_email');
	        $review->comment = $request->input('comment');
	        $review->speaker_id = $request->input('speaker_id');
	        $review->talk_id = '1';
	        $review->save();
	        for($i=1;$i<count($review_ratings);$i++){
	        	$review->review_options()->attach($i,['score_id'=>$score[$i-1]]);
	        }
          	return $this->response->array($review->toArray());
        }
        catch(\Exception $e){
           // do task when error
           return $this->response->error($e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id)
    {
        /*try{
          $review = Review::find($id);
          $review->review_name = $request->input('review_name');
          $review->review_englishname = $request->input('review_englishname');
          $review->review_company = $request->input('review_company');
          $review->review_title = $request->input('review_title');
          $review->review_language = $request->input('review_language');
          $review->review_description = $request->input('review_description');
          $review->review_email = $request->input('review_email');
          $file = $request->file('image');
          if($file != null){
              $image_name = time()."-".$file->getClientOriginalName();
              $file->move('uploads/reviews/', $image_name);
              $review->review_photo = $image_name;
              $review->local_path = 'uploads/reviews/'.$image_name;
          }
          $review->save();
          return $this->response->array($review->toArray());
        }
        catch(\Exception $e){
           // do task when error
           return $this->response->error($e->getMessage(), 500);
        }*/
    }
}
