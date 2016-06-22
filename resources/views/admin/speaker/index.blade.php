@extends('layouts.admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Speaker
                        <!--<small>Subheading</small>-->
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href={{url( 'admin/dashboard')}}>Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-male"></i> Speaker
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-sm-11">
                            <h2>Speaker</h2>
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" class="btn btn-default" id="btn-add">
                                <i class="fa fa-btn fa-plus"></i> Create
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>English Name</th>
                                <th>Language</th>
                                <th>Company</th>
                                <th>Title</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($speakers as $speaker)
                                <tr>
                                    <td>{{$speaker->id}}</td>
                                    <td>{{$speaker->speaker_name}}</td>
                                    <td>{{$speaker->speaker_englishname}}</td>
                                    <td>{{$speaker->speaker_language}}</td>
                                    <td>{{$speaker->speaker_company}}</td>
                                    <td>{{$speaker->speaker_title}}</td>
                                    <td>{{$speaker->speaker_email}}</td>
                                    <td>
                                        <div>
                                        <button class="btn btn-info open-modal" name="speaker_update" value="{{$speaker->id}}" id="btn-update">Update</button>
                                        
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'style' => 'display:inline-block',
                                                'url' => 'speaker/'.$speaker->id
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
                    {{ $speakers->render() }}
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        <!--Modal-->
        <div id="gridSystemModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Create Speaker</h4>
                    </div>
                    <div class="modal-body">
                        <form id="speakerForm" action='{{url('speaker')}}' method="POST" class="form-horizontal" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    {{ csrf_field() }}
                                    <div class="form-group col-md-12">
                                        <h3><label for="speaker-name">講師的姓名</label></h3>
                                        <p>中文姓名，例如：黃韋力</p>
                                        <input type="text" name="speaker-name" id="speaker-name" class="form-control" value="{{old('speaker-name')}}"> @if ($errors->has('speaker-name'))
                                            <br>
                                            <p class="alert alert-danger">{{ $errors->first('speaker-name') }}</p> @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="speaker-en-name">講師的英文姓名</label></h3>
                                        <p>英文姓名，例如：Willie Huang</p>
                                        <input type="text" name="speaker-en-name" id="speaker-en-name" class="form-control" placeholder="Willie Huang" value="{{old('speaker-en-name')}}"> @if ($errors->has('speaker-en-name'))
                                            <br>
                                            <p class="alert alert-danger">{{ $errors->first('speaker-en-name') }}</p> @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="speaker-company">講師的公司</label></h3>
                                        <p></p>
                                        <input type="text" name="speaker-company" id="speaker-company" class="form-control" value="{{old('speaker-company')}}"> @if ($errors->has('speaker-company'))
                                            <br>
                                            <p class="alert alert-danger">{{ $errors->first('speaker-company') }}</p> @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="speaker-title">講師的職位</label></h3>
                                        <p></p>
                                        <input type="text" name="speaker-title" id="speaker-title" class="form-control" value="{{old('speaker-title')}}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="speaker-lang">講師發表演講通常用的語言</label></h3>
                                        <p></p>
                                        <div class="radio">
                                            <label>
                                                <input name="speaker-lang" type="radio" value="1" @if (old( 'speaker-lang')=="1" ) checked @endif>中文</label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input name="speaker-lang" type="radio" value="2" @if (old( 'speaker-lang')=="2" ) checked @endif>英文</label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input name="speaker-lang" type="radio" value="999" @if (old( 'speaker-lang')=="999" ) checked @endif>其他
                                                <input type="text" name="speaker-lang-field" id="speakerLang_field" value="{{old(" speaker-lang-field ")}}">
                                            </label>
                                        </div>
                                        @if ($errors->has('speaker-lang'))
                                            <br>
                                            <p class="alert alert-danger">{{ $errors->first('speaker-lang') }}</p> @endif @if ($errors->has('speaker-lang-field'))
                                            <br>
                                            <p class="alert alert-danger">{{ $errors->first('speaker-lang-field') }}</p> @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="speaker-description">講師的簡單介紹</label></h3>
                                        <p>盡量廣泛，不要限制於本次的演講。如果網路上尚有講師的簡介可以直接複製到這裡或者提供超鏈接</p>
                                        <textarea rows="5" name="speaker-description" id="speaker-description" class="form-control">{{old('speaker-description')}}</textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="speaker-email">講師的email</label></h3>
                                        <p>有了講師的email就可以邀請他設定他的profile。不知道可以留空白。</p>
                                        <input type="text" name="speaker-email" id="speaker-email" class="form-control" value="{{old('speaker-email')}}">
                                        @if ($errors->has('speaker-email'))
                                        <br>
                                        <p class="alert alert-danger">{{ $errors->first('speaker-email') }}</p> @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="speaker-photo">講師的照片</label></h3>
                                        <p>有了講師的照片，就可以把它加在講師的profile上</p>
                                        {!! Form::file('image', null ) !!}
                                        @if ($errors->has('image'))
                                            <br>
                                            <p class="alert alert-danger">{{ $errors->first('image') }}</p> 
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12" style="display:none">
                                        <input type="text" name="form-type" class="form-control" value="single">
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
    <!-- /#page-wrapper -->
    @if ($errors->any())
        <script>
            $('#gridSystemModal').modal('show');
        </script>
    @endif
    <script>
    $(document).ready(function(){
        var url = "/speaker";
        //display modal form for creating new speaker
        $('#btn-add').click(function(){
            $('.alert').remove();
            $('#speakerForm').trigger("reset");
            $('#speakerForm').attr('action','{{url('speaker')}}');
            $('#speakerForm').attr('method','POST');
            $('#gridSystemModalLabel').text('Create Speaker');
            $('#gridSystemModal').modal('show');
        });


        $('.open-modal').click(function(){
            $('#speakerForm').trigger("reset");
            $('.alert').remove();
            var speaker_id = $(this).val(); 
            
            $.ajax({
                type: 'GET',
                url: url+'/'+speaker_id,
                success: function (data) {
                    $('#speaker-name').val(data.speaker_name);
                    $('#speaker-en-name').val(data.speaker_englishname);
                    $('#speaker-company').val(data.speaker_company);
                    $('#speaker-title').val('');
                    $('#speaker-lang').val($("input[name='']:checked").val());
                    $('#speakerForm').find(':radio[name=speaker-lang][value="'+data.speaker_language+'"]').prop('checked', true);
                    $('#speaker-description').val(data.speaker_description);
                    $('#speaker-email').val(data.speaker_email);
                    $('#speaker-image').val('');
                    $('#speakerForm').attr('action',url+'/'+speaker_id);
                    $('#speakerForm').attr('method','POST');
                    $('#gridSystemModalLabel').text('Update Speaker');
                    $('#gridSystemModal').modal('show');
                },
                error: function (data) {
                    console.log('Error:', data);
            }
        });
        });
    });
    </script>
@endsection