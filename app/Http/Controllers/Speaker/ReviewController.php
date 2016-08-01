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
          $review_with_relation = $review->toArray();
          $review_with_relation['speaker'] = $review->speaker;
          $review_with_relation['user'] = $review->user;
          unset($review_with_relation['speaker_id']);
          unset($review_with_relation['user_id']);
          
        	$review_with_rating['review'] = $review_with_relation;
	        $review_with_rating['review_rating'] = $review->review_options()->get();
	        $review_data[] = $review_with_rating;
	    }
        return $this->response->array(['reviews' => $review_data]);

    }

    public function getReview($id)
    {
        $review = Review::findOrFail($id);
        $review_rating = $review->review_options()->get();
        $review_data = $review->toArray();
        $review_data['speaker'] = $review->speaker;
        $review_data['user'] = $review->user;
        unset($review_data['speaker_id']);
        unset($review_data['user_id']);
        return $this->response->array(['review' => $review_data, 'review_rating' => $review_rating->toArray()]);
    }

    public function getLastReview($count)
    {
        $reviews = Review::orderBy('id', 'desc')->take($count)->get();
        $review_with_rating = array();
        $review_data = array();
        foreach($reviews as $review){
          $review_with_relation = $review->toArray();
          $review_with_relation['speaker'] = $review->speaker;
          $review_with_relation['user'] = $review->user;
          unset($review_with_relation['speaker_id']);
          unset($review_with_relation['user_id']);

          $review_with_rating['review'] = $review_with_relation;
          $review_with_rating['review_rating'] = $review->review_options()->get();
          $review_data[] = $review_with_rating;
        }
        return $this->response->array(['reviews' => $review_data]);
    }

    public function getQuote($count)
    {
        $reviews = Review::whereNotNull('quote')->where('quote','<>','')->orderByRaw('RAND()')->take($count)->get();
        foreach($reviews as $review){
          $quote[] = $review->quote;
        }
        return $this->response->array(['quotes' => $quote]);
    }

    public function store(Request $request)
    {
        try{
	        $review = new Review;
	        $review_ratings = ReviewOption::all();
	        $score = $request->input('score');
	        if(count($score)<5) return $this->response->error('Score count is less than 5', 500);
          $review->user_id = $request->input('user_id');
	        //$review->user_name = $request->input('user_name');
	        //$review->user_email = $request->input('user_email');
          $review->moderation_comment = 0;
          $review->moderation_quote = 0;
          $review->quote = $request->input('quote');
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
        try{
          $review = Review::findOrFail($id);
          $review_ratings = ReviewOption::all();
          $score = $request->input('score');
          if(count($score)<5) return $this->response->error('Score count is less than 5', 500);
          $review->user_id = $request->input('user_id');
          //$review->user_name = $request->input('user_name');
          //$review->user_email = $request->input('user_email');
          $review->quote = $request->input('quote');
          $review->comment = $request->input('comment');
          $review->speaker_id = $request->input('speaker_id');
          $review->talk_id = '1';
          $review->save();
          $review->review_options()->detach();
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
}
