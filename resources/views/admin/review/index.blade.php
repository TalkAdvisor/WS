@extends('layouts.admin')

@section('content')

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Review
                        <small>Subheading</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href={{url('admin/dashboard')}}>Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-male"></i> Review
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-sm-11">
                            <h2>Review</h2>
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" class="btn btn-default" data-toggle="modal"
                                    data-target="#gridSystemModal">
                                <i class="fa fa-btn fa-plus"></i> Create
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>User Email</th>
                                <th>Comment</th>
                                <th>Talk</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($reviews as $review)
                                <tr>
                                    <td>{{$review->id}}</td>
                                    <td>{{$review->user_name}}</td>
                                    <td>{{$review->user_email}}</td>
                                    <td>{{$review->comment}}</td>
                                    <td>{{$review->talk_id}}</td>
                                    <td>
                                        <div>
                                        <button class="btn btn-info open-modal" name="talk_update" value="{{$review->id}}" id="btn-update">Update</button>
                                        
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'style' => 'display:inline-block',
                                                'url' => 'review/'.$review->id
                                            ]) !!}
                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $reviews->render() }}
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        <!--Modal-->
        <div id="gridSystemModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Create Review</h4>
                    </div>
                    <div class="modal-body">
                        <form action='{{url('review')}}' id="reviewForm" method="POST" class="form-horizontal">
                            {{ csrf_field() }}
                            <div class="form-group  col-md-12">
                                <h3><label>演講的主題</label></h3>
                                <select class="form-control" name="talk_id">
                                    @foreach ($talks as $talk)
                                        <option value="{{ $talk->id }}"
                                                @if (old('talk_id') == $talk->id) selected="selected" @endif>{{ $talk->topic }}</option>
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
                                        @for ($line = 0; $line < count($scores); $line++)
                                            <tr>
                                                <td>{{$scores[$line]["title"]}}</td>
                                                @for ($i = 5; $i > 0; $i--)
                                                    <td>
                                                        <div class="radio" style="text-align: left;">
                                                            <label class="sg-cell sg-cell-{{$i}} sg-cell-data">
                                                                <input name="{{$scores[$line]["name"]}}"
                                                                       id="{{$scores[$line]["name"]}}-{{$line}}-{{$i}}"
                                                                       type="radio" class="sg-input sg-input-radio"
                                                                       value="{{ $i }}"
                                                                       @if (old($scores[$line]["name"]) == $i) checked @endif>
                                                                <label for="{{$scores[$line]["name"]}}-{{$line}}-{{$i}}"></label>
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
                                @if ($errors->has('content-score'))<br><p
                                        class="alert alert-danger">{{ $errors->first('content-score') }}</p> @endif
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
                                       value="single">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
</div>
    <!-- /#page-wrapper -->
    @if ($errors->any())
        <script>
            $('#gridSystemModal').modal('show');
        </script>
    @endif
@endsection