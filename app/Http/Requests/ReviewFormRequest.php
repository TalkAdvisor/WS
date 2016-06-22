<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Http\JsonResponse;

class ReviewFormRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'total-score' => 'required',
            'relevance-score' => 'required',
            'clear-score' => 'required',
            'inspiration-score' => 'required',
            'interest-score' => 'required',
            'interviewee-name' => 'required',
            'interviewee-email' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'total-score.required' => '總和評分不得為空白',
            'relevance-score.required' => '與預告講題的相關度不得為空白',
            'clear-score.required' => '容易懂不得為空白',
            'inspiration-score.required' => '啓發性不得為空白',
            'interest-score.required' => '讓人投入不得為空白',
            'interviewee-name.required' => '你的姓名不得為空白',
            'interviewee-email.required' => '你的email不得為空白'
        ];
    }

    /*public function response(array $errors)
    {
        return new JsonResponse($errors, 422);
    }*/

}