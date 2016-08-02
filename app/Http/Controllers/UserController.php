<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Auth;
use App\User;
use App\Model\Review;
use App\Http\Requests;
use Bican\Roles\Models\Role;

class UserController extends Controller
{
    public function authenticate()
    {
    	$email = Input::get('email');
        $password = Input::get('password');
        if (Auth::attempt(array('email' => $email, 'password' => $password))){
        	$user = User::where('email','=',$email)->firstOrFail();
        	if ($user->hasRole('user')) { 
			    return $this->response->array(['message'=>'success','user' => $user->toArray()]);
			}else{
				return $this->response->array(['message'=>'Wrong role']);
			}
        }
        else {
            return $this->response->array(['message'=>'Wrong Credentials']);
        }
    }

    public function getUser($id)
    {
    	$user = User::find($id);
        if ($user) { 
			return $this->response->array(['user' => $user->toArray()]);
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

    public function update($id)
    {
    	try{
    		$name = Input::get('name');

	    	$user = User::find($id);
	    	$user->name = $name;
	    	$user->save();
	    	return $this->response->array(['user' => $user->toArray()]);
	    }
        catch(\Exception $e){
            // do task when error
            return $this->response->error($e->getMessage(), 500);
        }	
    }

    public function register()
    {
    	try{
	    	$name = Input::get('name');
	    	$email = Input::get('email');
	        $password = Input::get('password');
	    	$user = User::create([
	            'name' => $name,
	            'email' => $email,
	            'password' => bcrypt($password),
	        ]);
	        $userRole = Role::where('slug','=','user')->first();
	        $user->attachRole($userRole->id);
	        return $this->response->array(['user' => $user->toArray()]);
        }
        catch(\Exception $e){
            // do task when error
            return $this->response->error($e->getMessage(), 500);
        }
    }
}
