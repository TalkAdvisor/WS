@extends('layouts.master')

@section('content')
    <style type="text/css" media="all">
        .sg-cell-1 input[type=radio] + label:before {
            content: "\E608";
        }

        .sg-cell-1 input[type=radio]:checked + label:before {
            content: "\E608";
            color: #157efb;
        }
        .sg-cell-2 input[type=radio] + label:before {
            content: "\E604";
        }

        .sg-cell-2 input[type=radio]:checked + label:before {
            content: "\E604";
            color: #157efb;
        }
        .sg-cell-3 input[type=radio] + label:before {
            content: "\E60a";
        }

        .sg-cell-3 input[type=radio]:checked + label:before {
            content: "\E60a";
            color: #157efb;
        }
        .sg-cell-4 input[type=radio] + label:before {
            content: "\E602";
        }

        .sg-cell-4 input[type=radio]:checked + label:before {
            content: "\E602";
            color: #157efb;
        }
        .sg-cell-5 input[type=radio] + label:before {
            content: "\E606";
        }

        .sg-cell-5 input[type=radio]:checked + label:before {
            content: "\E606";
            color: #157efb;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="box">
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>講者: {{$speaker->talker_name}}</h3>
                        </div>

                        <div class="panel-body">
                            <form action='{{url('review')}}' id="reviewForm" method="POST" class="form-horizontal">
                                {{ csrf_field() }}
                                <div class="form-group  col-md-12">
                                    <h3><label>演講的主題</label></h3>
                                    <select class="form-control" name="event_id">
                                        @foreach ($events as $event)
                                            <option value="{{ $event->id }}"
                                                    @if (old('event_id') == $event->id) selected="selected" @endif>{{ $event->topic }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group  col-md-12 sg-replace-icons sg-question sg-type-radio sg-type-radio-likert">
                                    <h3><label for="questionnaire-score">演講的評分</label></h3>
                                    <p></p>
                                    <div class="table-responsive sg-rating-scale">
                                        <table class="table table-striped">
                                            <tr>
                                                <td></td>
                                                <td>非常好</td>
                                                <td>好</td>
                                                <td>尚可</td>
                                                <td>差</td>
                                                <td>非常差</td>
                                            </tr>
                                            @for ($line = 0; $line <= 4; $line++)
                                                <tr>
                                                    <td>
                                                        <strong><p>{{$score[$line]["title"]}}</p></strong>
                                                        <p>{{$score[$line]["detail"]}}</p>
                                                    </td>
                                                    @for ($i = 5; $i > 0; $i--)
                                                        <td>
                                                            <div class="radio" style="text-align: left;">
                                                                <label class="sg-cell sg-cell-{{$i}} sg-cell-data">
                                                                    <input name="{{$score[$line]["name"]}}" id="{{$score[$line]["name"]}}-{{$line}}-{{$i}}" type="radio" class="sg-input sg-input-radio"
                                                                           value="{{ $i }}"
                                                                           @if (old($score[$line]["name"]) == $i) checked @endif>
                                                                    <label for="{{$score[$line]["name"]}}-{{$line}}-{{$i}}"></label>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    @endfor
                                                </tr>
                                            @endfor
                                        </table>
                                    </div>
                                    @if ($errors->has('total-score'))<br><p
                                            class="alert alert-danger">{{ $errors->first('total-score') }}</p> @endif
                                    @if ($errors->has('relevance-score'))<br><p
                                            class="alert alert-danger">{{ $errors->first('relevance-score') }}</p> @endif
                                    @if ($errors->has('clear-score'))<br><p
                                            class="alert alert-danger">{{ $errors->first('clear-score') }}</p> @endif
                                    @if ($errors->has('inspiration-score'))<br><p
                                            class="alert alert-danger">{{ $errors->first('inspiration-score') }}</p> @endif
                                    @if ($errors->has('interest-score'))<br><p
                                            class="alert alert-danger">{{ $errors->first('interest-score') }}</p> @endif
                                </div>
                                <div class="form-group  col-md-12">
                                    <h3><label for="questionnaire-comment">個人評論</label></h3>
                                    <p>你願意花點時間分享你的經驗與評論很有價值！就可以讓很多人了解本次演講的講師值不值得他們的時間、注意力與金錢！</p>
                                    <input type="text" name="comment" id="questionnaire-comment" class="form-control"
                                           value="{{old('comment')}}">
                                </div>
                                <div class="form-group  col-md-12">
                                    <h3><label for="questionnaire-interviewee-name">你的姓名</label></h3>
                                    <p></p>
                                    <input type="text" name="interviewee-name" id="questionnaire-interviewee-name"
                                           class="form-control" value="{{old('interviewee-name')}}">
                                    @if ($errors->has('interviewee-name'))<br><p
                                            class="alert alert-danger">{{ $errors->first('interviewee-name') }}</p> @endif
                                </div>
                                <div class="form-group  col-md-12">
                                    <h3><label for="questionnaire-interviewee-email">你的email</label></h3>
                                    <p></p>
                                    <input type="text" name="interviewee-email" id="questionnaire-interviewee-email"
                                           class="form-control" value="{{old('interviewee-email')}}">
                                    @if ($errors->has('interviewee-email'))<br><p
                                            class="alert alert-danger">{{ $errors->first('interviewee-email') }}</p> @endif
                                </div>
                                <div class="form-group col-md-12" style="display:none">
                                    <input type="text" name="form-type" class="form-control"
                                           value="frontend">
                                </div>
                                <div class="form-group col-md-12" style="display:none">
                                    <input type="text" name="talker_id" class="form-control"
                                           value="{{$speaker->id}}">
                                </div>
                                <!-- Add Task Button -->
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fa fa-btn fa-arrow-right"></i>Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $( "button" ).click(function() {
            $( "#speakerForm" ).slideToggle( "slow" );
        });
        $( "#speakerList" ).change(function() {
            window.location.href = "{{ url('admin/events/create') }}";
        });
    </script>
@endsection