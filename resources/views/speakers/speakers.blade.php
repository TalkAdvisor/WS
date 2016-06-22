@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="box">
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        <h2 class="intro-text text-center">
                            <strong>Speakers</strong>
                        </h2>
                        <hr>
                        <br>
                        @foreach($speakers as $speaker)
                            <div class="row" style="text-align:center;">
                                <div class="col-md-3"
                                     style="width:250px; height:200px;overflow:hidden;display:inline-block;">
                                    <img class="img-responsive img-border"
                                         src="{{url('uploads/speakers').'/'.$speaker->local_path}}" alt=""
                                         style="max-width:200px;_width:expression(this.width > 200 ? '200px' : this.width);">
                                </div>
                                <div class="col-md-9" >
                                    <hr class="visible-xs">
                                    <p><strong>講師: </strong>{{$speaker->speaker_name}}</p>
                                    <p>{{$speaker->speaker_description}}</p>
                                    <p><a href="{{url('speaker').'/'.$speaker->id}}" class="btn btn-primary">詳細資訊</a></p>
                                </div>
                            </div>
                            <br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection