<?php

namespace App\Http\Controllers\Questionnaire;


use View;
use Session;

use Illuminate\Http\Request;
use App\Questionnaire;
use App\Talker;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionnaireFormRequest;
use App\Http\Requests\TalkerFormRequest;

class QuestionnaireController extends Controller
{
    /**
     * Responds to requests to GET /questionnaire
     */
    public function index()
    {
        $score = array(
            0=>array(
                "title"=>"總和評分",
                "name"=>"total-score"
            ),
            1=>array(
                "title"=>"與預告講題的相關度",
                "name"=>"relevance-score"
            ),
            2=>array(
                "title"=>"容易懂",
                "name"=>"clear-score"
            ),
            3=>array(
                "title"=>"啓發性",
                "name"=>"inspiration-score"
            ),
            4=>array(
                "title"=>"好玩",
                "name"=>"interest-score"
            ),
            5=>array(
                "title"=>"內容",
                "name"=>"content-score"
            )
        );
        return View::make('questionnaires.create')->with("score",$score);
    }

    public function create(QuestionnaireFormRequest $request){
        $requestData = [
            'talkerName' => $request->input('talker-name'),
            'talkerEnName' => $request->input('talker-en-name'),
            'topic' => $request->input('topic'),
            'event' => $request->input('event'),
            'series' => $request->input('series'),
            'date' => $request->input('date'),
            'city' =>  $request->input('city'),
            'othersCity' => $request->input('city-field'),
            'location' => $request->input('location'),
            'othersLocation' => $request->input('location-field'),
            'organizer' => $request->input('organizer'),
            'othersOrganizer'=> $request->input('organizer-field'),
            'quote' => $request->input('quote'),
            'totalScore' => $request->input('total-score'),
            'relevanceScore' => $request->input('relevance-score'),
            'clearScore' => $request->input('clear-score'),
            'inspirationScore' => $request->input('inspiration-score'),
            'interestScore' => $request->input('interest-score'),
            'contentScore' => $request->input('content-score'),
            'comment' => $request->input('comment'),
            'intervieweeName' => $request->input('interviewee-name'),
            'intervieweeEmail' => $request->input('interviewee-email')
        ];
        $nextStep = $request->get('next_step');

        if($nextStep=='true'){
            Session::put('requestData', $requestData);
            return View::make('talkers.create');
        }else{
            $this->store($requestData);
            return  $requestData;
        }
    }

    public function store(Array $requestData){
        $questionnaire = new Questionnaire;
        $questionnaire->talker_name = $requestData['talkerName'];
        $questionnaire->talker_englishname = $requestData['talkerEnName'];
        $questionnaire->topic =  $requestData['talkerEnName'];
        $questionnaire->event =  $requestData['event'];
        $questionnaire->event_series =  $requestData['series'];
        $questionnaire->start_date =  $requestData['date'];
        $questionnaire->talk_city =  $requestData['city'];
        $questionnaire->extend_city =  $requestData['othersCity'];
        $questionnaire->talk_location =  $requestData['location'];
        $questionnaire->extend_location =  $requestData['othersLocation'];
        $questionnaire->organizer =  implode(',',$requestData['organizer']);
        $questionnaire->extend_organizer =  $requestData['othersOrganizer'];
        $questionnaire->talker_quote =  $requestData['quote'];
        $questionnaire->total_score =  $requestData['totalScore'];
        $questionnaire->relevance_score =  $requestData['relevanceScore'];
        $questionnaire->clear_score =  $requestData['clearScore'];
        $questionnaire->inspiration_score =  $requestData['inspirationScore'];
        $questionnaire->interest_score =  $requestData['interestScore'];
        $questionnaire->content_score =  $requestData['contentScore'];
        $questionnaire->interviewee_name =  $requestData['intervieweeName'];
        $questionnaire->interviewee_email =  $requestData['intervieweeEmail'];
        $questionnaire->save();
    }

    public function talkerStore(TalkerFormRequest $request)
    {
        $requestData = Session::get('requestData');
        $this->store($requestData);
        $talker = new Talker;
        $talker->talker_company = $request->input('talker-company');
        $talker->talker_title = $request->input('talker-title');
        $talker->talker_language = $request->input('talker-lang');
        $talker->talker_description = $request->input('talker-description');
        $talker->talker_email = $request->input('talker_email');
        $file = $request->file('image');
        if($file != null){
            $image_name = time()."-".$file->getClientOriginalName();
            $file->move('uploads', $image_name);
            $talker->talker_photo = 'uploads/'.$image_name;
            $talker->local_path = 'local';
        }
        $talker->save();
        Session::forget('requestData');
        return View::make('questionnaire.thanksPage');
    }

}
