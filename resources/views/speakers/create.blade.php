@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="box">
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>講師的基本訊息</h3>
                        </div>

                        <div class="panel-body">
                            <!-- Display Validation Errors -->
                            <!-- New Task Form -->
                            <form action='/questionnaire/talkerStore' method="POST" class="form-horizontal"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}

                                        <!-- Task Name -->
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

                                <!-- Add Task Button -->
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <button class="btn btn-default" onclick="window.history.back();">
                                            <i class="fa fa-btn fa-arrow-left"></i>Back
                                        </button>
                                        <button type="submit" class="btn btn-default">
                                            <i class="fa fa-btn fa-check"></i>Submit
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
@endsection