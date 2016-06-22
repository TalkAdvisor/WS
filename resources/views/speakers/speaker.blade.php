@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="box">
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        <h2 class="intro-text text-center">
                            <strong>Speaker</strong>
                        </h2>
                        <hr>
                        <br>
                            <div class="row" style="text-align:center;">
                                <div class="col-md-6"
                                     style="overflow:hidden;display:inline-block;">
                                    <img class="img-responsive img-border"
                                         src="{{url('uploads/speakers').'/'.$speaker->local_path}}" alt=""
                                         style="max-width:300px;_width:expression(this.width > 300 ? '300px' : this.width);">
                                </div>
                                <div class="col-md-6">
                                    <hr class="visible-xs">
                                    <p><strong>講師: </strong>{{$speaker->speaker_name}}</p>
                                    <p>{{$speaker->speaker_description}}</p>
                                </div>
                            </div>
                            <br>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="box">
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        <h2 class="intro-text text-center">
                            <strong>Rating</strong>
                        </h2>
                        <hr>
                        <br>
                        <table class="table table-hover">
                            <tbody>
                            @foreach ($review_options as $review_option)
                                <tr>
                                    <td>{{$review_option->name}}</td>
                                    <td>
                                        @for($i=1;$i<=$review_option->pivot->score_id;$i++)
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        @endfor
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if($speaker->video != null)
            <div class="row">
                <div class="box text-center">
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <h2 class="intro-text text-center">
                                <strong>Video</strong>
                            </h2>
                            <hr>
                            <br>
                            <iframe width="500px" height="315px" src="{{$speaker->video}}" frameborder="0" allowfullscreen style="max-width: 100%;"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="box">
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        <h2 class="intro-text text-center">
                            <strong>Upcoming Talks</strong>
                        </h2>
                        <hr>
                        <br>
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>講座主題</th>
                                            <th>講座日期</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($events as $event)
                                            <tr>
                                                <td>{{$event->topic}}</td>
                                                <td>{{$event->start_date}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="box">
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        <h2 class="intro-text text-center">
                            <strong>Comment</strong>
                        </h2>
                        <hr>
                        <br>
                        @foreach ($reviews as $review)
                            <div class="row" style="text-align:center;">
                                <div class="col-md-4">
                                    <p>{{$review->user_name}}</p>
                                </div>
                                <div class="col-md-4">
                                    <p>{{$review->created_at}}</p>
                                </div>
                                <div class="col-md-4">
                                    <hr class="visible-xs">
                                    <p>{{$review->comment}}</p>
                                </div>
                            </div>
                            <br>
                        @endforeach
                        <h2 class="intro-text text-center"><a href="{{url('review/speaker').'/'.$speaker->id}}" class="btn btn-primary">我要評論</a></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection