@extends('layouts.admin')

@section('content')
    <div id="page-wrapper">

        <div class="container-fluid">
        <div class="row">
            <div class="box">
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>選擇講師</h3>
                        </div>

                        <div class="panel-body">
                            <!-- Display Validation Errors -->
                            <!-- New Task Form -->
                                <div class="form-group row">
                                    <div class="col-md-11">
                                    <select class="form-control" id="speakerList">
                                        <option value="0">請選擇講師</option>
                                        @foreach ($speakers as $speaker)
                                            <option value={{$speaker->id}}>{{$speaker->talker_name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <button class="btn btn-default glyphicon glyphicon-plus" onclick="formToggle()"></button>
                                </div>
                            <form id="speakerForm" action='/talker' method="POST" class="form-horizontal"
                                  enctype="multipart/form-data" @if (!$errors->any()) style="display:none;" @endif>
                                {{ csrf_field() }}
                                        <!-- Task Name -->
                                <div class="form-group col-md-12">
                                    <h3><label for="talker-name">講師的姓名</label></h3>
                                    <p>中文姓名，例如：黃韋力</p>
                                    <input type="text" name="talker-name" id="talker-name" class="form-control"
                                           value="{{old('talker-name')}}">
                                    @if ($errors->has('talker-name'))<br><p
                                            class="alert alert-danger">{{ $errors->first('talker-name') }}</p> @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <h3><label for="talker-en-name">講師的英文姓名</label></h3>
                                    <p>英文姓名，例如：Willie Huang</p>
                                    <input type="text" name="talker-en-name" id="talker-en-name" class="form-control"
                                           placeholder="Willie Huang" value="{{old('talker-en-name')}}">
                                    @if ($errors->has('talker-en-name'))<br><p
                                            class="alert alert-danger">{{ $errors->first('talker-en-name') }}</p> @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <h3><label for="talker-company">講師的公司</label></h3>
                                    <p></p>
                                    <input type="text" name="talker-company" id="talker-company" class="form-control"
                                           value="">
                                    @if ($errors->has('talker-company'))<br><p
                                            class="alert alert-danger">{{ $errors->first('talker-company') }}</p> @endif
                                </div>
                                <div class="form-group  col-md-12">
                                    <h3><label for="talker-title">講師的職位</label></h3>
                                    <p></p>
                                    <input type="text" name="talker-title" id="talker-title" class="form-control"
                                           value="">
                                </div>
                                <div class="form-group  col-md-12">
                                    <h3><label for="talker-lang">講師發表演講通常用的語言</label></h3>
                                    <p></p>
                                    <div class="radio">
                                        <label><input name="talker-lang" type="radio" value="1"
                                                      @if (old('talker-lang') == "1") checked @endif>中文</label>
                                    </div>
                                    <div class="radio">
                                        <label><input name="talker-lang" type="radio" value="2"
                                                      @if (old('talker-lang') == "2") checked @endif>英文</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input name="talker-lang" type="radio" value="999"
                                                   @if (old('talker-lang') == "999") checked @endif>其他
                                            <input type="text" name="talker-lang-field" id="talkerLang_field"
                                                   value="{{old("talker-lang-field")}}">
                                        </label>
                                    </div>
                                    @if ($errors->has('talker-lang'))<br><p
                                            class="alert alert-danger">{{ $errors->first('talker-lang') }}</p> @endif
                                    @if ($errors->has('talker-lang-field'))<br><p
                                            class="alert alert-danger">{{ $errors->first('talker-lang-field') }}</p> @endif
                                </div>
                                <div class="form-group  col-md-12">
                                    <h3><label for="talker-description">講師的簡單介紹</label></h3>
                                    <p>盡量廣泛，不要限制於本次的演講。如果網路上尚有講師的簡介可以直接複製到這裡或者提供超鏈接</p>
                                    <textarea rows="5" name="talker-description" id="talker-description"
                                              class="form-control" value=""></textarea>
                                </div>
                                <div class="form-group  col-md-12">
                                    <h3><label for="talker-email">講師的email</label></h3>
                                    <p>有了講師的email就可以邀請他設定他的profile。不知道可以留空白。</p>
                                    <input type="text" name="talker-email" id="talker-email" class="form-control"
                                           value="">
                                </div>
                                <div class="form-group  col-md-12">
                                    <h3><label for="talker-photo">講師的照片</label></h3>
                                    <p>有了講師的照片，就可以把它加在講師的profile上</p>
                                    {!! Form::file('image', null) !!}
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fa fa-btn fa-check"></i>Next
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
        </div>
    <script>
        $( "button" ).click(function() {
            $( "#speakerForm" ).show(1000);;
        });
        $( "#speakerList").change(function() {
            var option = $(this).val();
            window.location.href = "{{ url('admin/form/event') }}?speakerId="+option;
        });
    </script>
@endsection