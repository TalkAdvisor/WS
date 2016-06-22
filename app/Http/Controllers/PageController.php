<?php

namespace App\Http\Controllers;


use View;
use Redirect;
use Session;

use Illuminate\Http\Request;
use App\Model\Speaker;
use App\Model\Util;
use App\Model\Talk;
use App\Model\Event;
use App\Model\Series;
use App\Model\Organizer;
use App\Model\Location;
use App\Model\Review;
use App\Model\ReviewOption;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionnaireFormRequest;
use App\Http\Requests\SpeakerFormRequest;

class PageController extends Controller
{

    public function login(){
        return View::make('admin.login');
    }
    public function getFormPage($type, Request $request)
    {
        switch($type){
            case 'speaker':
                return View::make('admin.form.speaker')->with("speakers",Speaker::all());
            case 'talk':
                $speakerId = $request->input('speakerId');
                $talkData = array(
                    "speaker" => Speaker::find($speakerId),
                    "talk" => Talk::where("speaker_id",'=', $speakerId)->get()
                );
                return View::make('admin.form.talk')->with("talkData",$talkData);
            case 'review':
                $speakerId = $request->input('speakerId');
                $talkId = $request->input('talkId');
                $reviewData = array(
                    "speaker" => Speaker::find($speakerId),
                    "talk" => Talk::where("speaker_id",'=', $speakerId)->get(),
                    "score" => Util::getScores()
                );
                return View::make('admin.form.review',array('speakerId' => $speakerId, 'talkId' => $talkId))->with("reviewData",$reviewData);
            default:
                return Redirect::to('/');
        }
    }

    public function getAdminPage($type)
    {
        Session::forget('tab');
        switch($type){
            case 'speaker':
                Session::flash('tab', 'speaker');
                return View::make('admin.speaker.index')->with("speakers",Speaker::paginate(10));
            case 'talk':
                Session::flash('tab', 'talk');
                return View::make('admin.talk.index')->with("talks",Talk::paginate(10))->with("speakers",Speaker::all());
                //return Talk::find(27)->speakers()->orderBy('id')->get();
            case 'review':
                Session::flash('tab', 'review');
                return View::make('admin.review.index')->with("reviews",Review::paginate(10))->with("talks",Talk::all())->with("scores",Util::getScores());
            case 'dashboard':
                Session::flash('tab', 'dashboard');
                return View::make('admin.dashboard');
            default:
                return Redirect::to('/');
        }
    }

    public function getAdminFormPage($type)
    {
        Session::forget('tab');
        switch($type){
            case 'speaker':
                Session::flash('tab', 'speaker');
                return View::make('admin.speaker.index')->with("speakers",Speaker::paginate(10));
            case 'talk':
                Session::flash('tab', 'talk');
                return View::make('admin.talk.create')->with("speakers",Speaker::all())->with("events",Event::all())->with("locations",location::all())->with("series",Series::all())->with("organizers",Organizer::all());
                //return Talk::find(27)->speakers()->orderBy('id')->get();
            case 'review':
                Session::flash('tab', 'review');
                return View::make('admin.review.index')->with("reviews",Review::paginate(10))->with("talks",Talk::all())->with("scores",Util::getScores());
            default:
                return Redirect::to('/');
        }
    }

    public function getSpeakerPage(){
        return View::make('speakers.speakers')->with('speakers',Speaker::all());
        //return View::make('speakers.speakers')->with('speakers',Speaker::all()->whereIn('id', [110,114,139,140,141]));
    }

    public function getSpeakerDetailPage($id){
        $speaker = Speaker::find($id);
        $talks = $speaker->talks;
        $talkId = array();
        foreach($talks as $talk){
            $talkId[] = $talk->id;
        }
        $reviews = Review::whereIn('talk_id',$talkId)->whereNotNull('comment')->get();
        //$review_options = ReviewOption::all();
        if(count($reviews) == 0){
            $review_options = array();
        }else{
            $review_options =  $reviews->first()->review_options()->get();
        }
        return View::make('speakers.speaker')->with('speaker',$speaker)->with('talks',$talks)->with('reviews',$reviews)->with('review_options',$review_options);
    }

    public function getReviewPage($id){
        $speaker = Speaker::find($id);
        $talks = $speaker->talks;
        return View::make('speakers.createReview')->with('speaker',$speaker)->with('talks',$talks)->with('score', Util::getScores());;
    }

}
