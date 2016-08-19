<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Auth;
use Storage;
use File;
use App\User;
use App\Model\Speaker;
use App\Model\Review;
use App\Http\Requests;
use Bican\Roles\Models\Role;
use Illuminate\Contracts\Filesystem\Filesystem;

class UserController extends Controller
{
    public function authenticate()
    {
    	$email = Input::get('email');
        $password = Input::get('password');
        if (Auth::attempt(array('email' => $email, 'password' => $password))){
        	$user = User::where('email','=',$email)->first();
			return $this->response->array(['message'=>'success','user' => $user->toArray()]);
        }
        else {
            return $this->response->array(['message'=>'Wrong Credentials']);
        }
    }

    public function getUser($id)
    {
    	$user = User::find($id);
        if ($user) { 
            $reviews = Review::where('user_id', '=', $user->id)->orderBy('id', 'desc')->get();
            $comments_count =  Review::where('user_id', '=', $user->id)->whereNotNull('comment')->count();
            $quotes_count =  Review::where('user_id', '=', $user->id)->whereNotNull('quote')->count();
            $ratings_count = 0;
            $total = array();
            $average = array();
            //total and ratings count
            foreach($reviews as $review){
                $ratings = $review->review_options()->get();
                if(count($ratings)>0){
                    $ratings_count++;
                    for($count=0;$count < count($ratings); $count++){
                       $total[$count] = ((count($total) < 5) ? 0:$total[$count]);
                       $total[$count] += $ratings[$count]->pivot->score; 
                    }
                }
            }
            //calculate average
            for($count=0;$count < count($total); $count++){
                $average[] = round($total[$count]/$ratings_count,2); 
            }

			return $this->response->array([
                'user' => $user->toArray(), 
                'reviews' => $reviews->toArray(), 
                'comments_count' => $comments_count,
                'ratings_count' => $ratings_count,
                'quotes_count' => $quotes_count,
                'average' => $average]);
		}else{
			return $this->response->array(['message'=>'The user is not exist']);
		}
    }

    public function leaveReview($user_id, $speaker_id)
    {
    	$review = Review::where('user_id','=',$user_id)->where('speaker_id','=',$speaker_id)->get();
    	if (count($review)) {
		    return $this->response->array(['status'=>'false','message'=>'You have already leave the review for this speaker.']);
		}else{
			return $this->response->array(['status'=>'true','message'=>'You can add review for this speaker.']);
		}
    }

    public function update($id, Request $request)
    {
    	try{
    		$s3 = Storage::disk('s3');
	    	$user = User::find($id);
	    	$user->name = $request->input('name');
	    	$user->phone_number = $request->input('phone_number');
            $user->facebook_id = $request->input('facebook_id');
            $file = $request->file('image');
            if($file != null){
              //upload image to server and s3
              $image_name = time()."-".$file->getClientOriginalName();
              $old_img = $user->profile_picture;
              $user->profile_picture = $image_name;
              $file->move('uploads/users/', $image_name);
              $local_path = 'uploads/users/'.$image_name;
              $s3->put('users/'.$image_name, file_get_contents($local_path));
              //delete old image
              $s3->delete('users/'.$old_img);
              File::delete('uploads/users/'.$old_img);
            }
            $user->save();
            return $this->response->array(['user' => $user->toArray()]);
        }
        catch(\Exception $e){
            // do task when error
            return $this->response->error($e->getMessage(), 500);
        }	
    }

    public function register(Request $request)
    {
    	try{
            $s3 = Storage::disk('s3');
            $fb_id = $request->input('facebook_id');
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            if($fb_id == null){
                $user->password = bcrypt($request->input('password'));
            }
            $user->facebook_id = $fb_id;
            $user->phone_number = $request->input('phone_number');
            $file = $request->file('image');
            if($file != null){
              //upload image to server and s3
              $image_name = time()."-".$file->getClientOriginalName();
              $old_img = $user->profile_picture;
              $user->profile_picture = $image_name;
              $file->move('uploads/users/', $image_name);
              $local_path = 'uploads/users/'.$image_name;
              $s3->put('users/'.$image_name, file_get_contents($local_path));
              //delete old image
              File::delete('uploads/users/'.$old_img);
            }
            $user->save();
	        $userRole = Role::where('slug','=','user')->first();
	        $user->attachRole($userRole->id);
	        return $this->response->array(['user' => $user->toArray()]);
        }
        catch(\Exception $e){
            // do task when error
            return $this->response->error($e->getMessage(), 500);
        }
    }

    public function socialLogin()
    {
        $email = Input::get('email');
        $fb_id = Input::get('fb_id');
        //$password = Input::get('password');
        $user = User::where('email','=',$email)->first();

        if ($user){          
            $user_facebook_id = $user->facebook_id;
            if($user_facebook_id == $fb_id && $user_facebook_id != null){
                return $this->response->array(['status'=>'1','message'=>'The account is existd in talkadvisor.','user' => $user->toArray()]);
            }else{
                return $this->response->array(['status'=>'2','message'=>'The account is existd in talkadvisor, but no facebook id.','user' => $user->toArray()]);
            }       
        }
        else {
            return $this->response->array(['status'=>'3','message'=>'No account in talkadvisor.']);
        }
    }

    public function getReview($id)
    {
        try{
            $user = User::findOrFail($id);
            $reviews = Review::where('user_id', '=', $user->id)->orderBy('id', 'desc')->get();
            if(count($reviews) > 0){
                $review_with_rating = array();
                $review_data = array();
                foreach($reviews as $review){
                  $review_with_relation = $review->toArray();
                  $review_with_relation['speaker'] = $review->speaker;
                  unset($review_with_relation['speaker_id']);
                  unset($review_with_relation['user_id']);

                  $review_with_rating['review'] = $review_with_relation;
                  $review_with_rating['review_rating'] = $review->review_options()->get();
                  $review_data[] = $review_with_rating;
                }
                return $this->response->array(['user' => $user->toArray(), 'reviews' => $review_data]);
            }else{
                return $this->response->array(['message' => 'No reviews from this speaker.']);
            }
        }catch(\Exception $e){
          // do task when error
          return $this->response->error($e->getMessage(), 500);
        } 
        
    }

    public function getQuote($id)
    {
        try{
            $user = User::findOrFail($id);
            $reviews = Review::where('user_id', '=', $user->id)->whereNotNull('quote')->get();
            if(count($reviews)>0){
              foreach($reviews as $review){
                if($review->speaker_id){
                   $quote[] = $review->quote;
                   $speaker[] = Speaker::findOrFail($review->speaker_id); 
                }                
              }
              return $this->response->array(['speaker' => $speaker, 'quotes' => $quote]);
            }else{
              return $this->response->array(['message' => 'No quotes from this User.']);
            }
        }catch(\Exception $e){
          // do task when error
          return $this->response->error($e->getMessage(), 500);
        } 
    }
}
