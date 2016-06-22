@extends('layouts.admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Speaker
                        <small>Subheading</small>
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-sm-11">
                            <h2>Speaker</h2>
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" id="btn-add" class="btn btn-default">
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
                                    <td>{{$speaker->talker_name}}</td>
                                    <td>{{$speaker->talker_englishname}}</td>
                                    <td>{{$speaker->talker_language}}</td>
                                    <td>{{$speaker->talker_company}}</td>
                                    <td>{{$speaker->talker_title}}</td>
                                    <td>{{$speaker->talker_email}}</td>
                                    <td>
                                        <a class="btn btn-primary" name="talker_update" talkerId="{{$speaker->id}}">Update</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
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
                        <form id="speakerForm" class="form-horizontal" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group col-md-12">
                                        <h3><label for="talker-name">講師的姓名</label></h3>
                                        <p>中文姓名，例如：黃韋力</p>
                                        <input type="text" name="talker-name" id="talker-name" class="form-control" value="{{old('talker-name')}}"> @if ($errors->has('talker-name'))
                                            <br>
                                            <p class="alert alert-danger">{{ $errors->first('talker-name') }}</p> @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="talker-en-name">講師的英文姓名</label></h3>
                                        <p>英文姓名，例如：Willie Huang</p>
                                        <input type="text" name="talker-en-name" id="talker-en-name" class="form-control" placeholder="Willie Huang" value="{{old('talker-en-name')}}"> @if ($errors->has('talker-en-name'))
                                            <br>
                                            <p class="alert alert-danger">{{ $errors->first('talker-en-name') }}</p> @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="talker-company">講師的公司</label></h3>
                                        <p></p>
                                        <input type="text" name="talker-company" id="talker-company" class="form-control" value=""> @if ($errors->has('talker-company'))
                                            <br>
                                            <p class="alert alert-danger">{{ $errors->first('talker-company') }}</p> @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="talker-title">講師的職位</label></h3>
                                        <p></p>
                                        <input type="text" name="talker-title" id="talker-title" class="form-control" value="">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="talker-lang">講師發表演講通常用的語言</label></h3>
                                        <p></p>
                                        <div class="radio">
                                            <label>
                                                <input name="talker-lang" id="talker-lang" type="radio" value="1" @if (old( 'talker-lang')=="1" ) checked @endif>中文</label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input name="talker-lang" id="talker-lang" type="radio" value="2" @if (old( 'talker-lang')=="2" ) checked @endif>英文</label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input name="talker-lang" id="talker-lang" type="radio" value="999" @if (old( 'talker-lang')=="999" ) checked @endif>其他
                                                <input type="text" name="talker-lang-field" id="talkerLang_field" value="{{old(" talker-lang-field ")}}">
                                            </label>
                                        </div>
                                        @if ($errors->has('talker-lang'))
                                            <br>
                                            <p class="alert alert-danger">{{ $errors->first('talker-lang') }}</p> @endif @if ($errors->has('talker-lang-field'))
                                            <br>
                                            <p class="alert alert-danger">{{ $errors->first('talker-lang-field') }}</p> @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="talker-description">講師的簡單介紹</label></h3>
                                        <p>盡量廣泛，不要限制於本次的演講。如果網路上尚有講師的簡介可以直接複製到這裡或者提供超鏈接</p>
                                        <textarea rows="5" name="talker-description" id="talker-description" class="form-control" value=""></textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="talker-email">講師的email</label></h3>
                                        <p>有了講師的email就可以邀請他設定他的profile。不知道可以留空白。</p>
                                        <input type="text" name="talker-email" id="talker-email" class="form-control" value="">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <h3><label for="talker-photo">講師的照片</label></h3>
                                        <p>有了講師的照片，就可以把它加在講師的profile上</p>
                                        <input name="image" id="talker-image" type="file">
                                    </div>
                                    <div class="form-group col-md-12" style="display:none">
                                        <input type="text" name="form-type" class="form-control" value="single">
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btn-save" value="add" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
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
    <meta name="_token" content="{!! csrf_token() !!}" />
    <script type="text/javascript" src = "{{asset('js/speaker-crud.js')}}"></script>
@endsection