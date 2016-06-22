@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="box">
                <div class="col-lg-offset-1 col-lg-10">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>選擇{{$eventData['speaker']->talker_name}}的講座</h3>
                        </div>

                        <div class="panel-body">
                            <!-- Display Validation Errors -->
                            <!-- New Task Form -->
                                <div class="form-group row">
                                    <div class="col-md-11">
                                    <select class="form-control" id="eventList">
                                        <option value="0" >請選擇{{$eventData['speaker']->talker_name}}主講的講座</option>
                                        @foreach ($eventData['event'] as $event)
                                            <option value={{$event->id}}>{{$event->topic}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <button class="btn btn-default glyphicon glyphicon-plus"></button>
                                </div>
                            <form action='/event' id="eventForm" method="POST" class="form-horizontal"  @if (!$errors->any()) style="display:none;" @endif>
                                {{ csrf_field() }}

                                <div class="form-group  col-md-12">
                                    <h3><label for="questionnaire-topic">演講的講題</label></h3>
                                    <p>按照演講邀請書上寫的</p>
                                    <input type="text" name="topic" id="questionnaire-topic" class="form-control"
                                           value="{{old('topic')}}">
                                    @if ($errors->has('topic'))<br><p
                                            class="alert alert-danger">{{ $errors->first('topic') }}</p> @endif
                                </div>
                                <div class="form-group  col-md-12">
                                    <h3><label for="questionnaire-event">如果本次演講屬於較大的活動，請填寫此活動的名稱</label></h3>
                                    <p>例如：創業小聚：第62場</p>
                                    <input type="text" name="event" id="questionnaire-event" class="form-control"
                                           value="">
                                </div>
                                <div class="form-group  col-md-12">
                                    <h3><label for="questionnaire-series">如果本次演講或者活動屬於一個系列，請填寫此系列的名稱</label></h3>
                                    <p>例如：『與創業達人有約』</p>
                                    <input type="text" name="series" id="questionnaire-series" class="form-control"
                                           value="">
                                </div>
                                <div class="form-group  col-md-12">
                                    <h3><label for="questionnaire-date">演講日期</label></h3>
                                    <p></p>
                                    <div class='input-group date'>
                                        <input type="text" name="date" id="questionnaire-date" class="form-control"
                                               value="{{old('date')}}">
                                <span class="input-group-addon" style="cursor:pointer">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </span>
                                    </div>
                                    @if ($errors->has('date'))<br><p
                                            class="alert alert-danger">{{ $errors->first('date') }}</p> @endif
                                </div>
                                <div class="form-group  col-md-12">
                                    <h3><label for="questionnaire-city">演講地點(城市)</label></h3>
                                    <p></p>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="city" id="city_1" value="台北"
                                                   @if (old('city') == "台北") checked @endif>
                                            台北
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="city" id="city_2" value="新北市"
                                                   @if (old('city') == "新北市") checked @endif>
                                            新北市
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="city" id="city_3" value="新竹"
                                                   @if (old('city') == "新竹") checked @endif>
                                            新竹
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="city" id="city_4" value="台中"
                                                   @if (old('city') == "台中") checked @endif>
                                            台中
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="city" id="city_5" value="高雄"
                                                   @if (old('city') == "高雄") checked @endif>
                                            高雄
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="city" id="city_6" value="999"
                                                   @if (old('city') == "999") checked @endif>
                                            Other
                                            <input type="text" name="city-field" id="city_6_field"
                                                   value="{{old("city-field")}}">
                                        </label>
                                    </div>
                                    @if ($errors->has('city'))<br><p
                                            class="alert alert-danger">{{ $errors->first('city') }}</p> @endif
                                    @if ($errors->has('city-field'))<br><p
                                            class="alert alert-danger">{{ $errors->first('city-field') }}</p> @endif
                                </div>
                                <div class="form-group  col-md-12">
                                    <h3><label for="questionnaire-location">演講詳細地點</label></h3>
                                    <p></p>
                                    <div class="radio">
                                        <label><input name="location" type="radio" value="1"
                                                      @if (old('location') == "1") checked @endif>Garage+
                                    </div>
                                    <div class="radio">
                                        <label><input name="location" type="radio" value="2"
                                                      @if (old('location') == "2") checked @endif>YOUR SPACE
                                            (數位時代)</label>
                                    </div>
                                    <div class="radio">
                                        <label><input name="location" type="radio" value="3"
                                                      @if (old('location') == "3") checked @endif>台大集思會議中心 GIS NTU
                                            Convention Center</label>
                                    </div>
                                    <div class="radio">
                                        <label><input name="location" type="radio" value="4"
                                                      @if (old('location') == "4") checked @endif>DOIT共創公域</label><br>
                                    </div>
                                    <div class="radio">
                                        <label><input name="location" type="radio" value="5"
                                                      @if (old('location') == "5") checked @endif>台大綜合體育館 NTU Sports
                                            Center</label>
                                    </div>
                                    <div class="radio">
                                        <label><input name="location" type="radio" value="6"
                                                      @if (old('location') == "6") checked @endif>台大醫院會議中心 NTUH
                                            International Convention Center</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input name="location" type="radio" value="999"
                                                   @if (old('city') == "999") checked @endif>Other
                                            <input type="text" name="location-field" id="location_field"
                                                   value="{{old("location-field")}}">
                                        </label>
                                    </div>
                                    @if ($errors->has('location'))<br><p
                                            class="alert alert-danger">{{ $errors->first('location') }}</p> @endif
                                    @if ($errors->has('location-field'))<br><p
                                            class="alert alert-danger">{{ $errors->first('location-field') }}</p> @endif
                                </div>
                                <div class="form-group  col-md-12">
                                    <h3><label for="questionnaire-organizer">演講主辦單位</label></h3>
                                    <p></p>
                                    <div class="checkbox">
                                        <label><input name="organizer[]" type="checkbox" value="1"
                                                      @if (old('organizer')) @if (in_array(1,old('organizer'))) checked @endif @endif>數位時代（創業小聚，客座創業家，IoT沙龍，Meet
                                            Taipei）</label><br>
                                    </div>
                                    <div class="checkbox">
                                        <label><input name="organizer[]" type="checkbox" value="2"
                                                      @if (old('organizer')) @if (in_array(2,old('organizer'))) checked @endif @endif>Garage+</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input name="organizer[]" type="checkbox" value="3"
                                                      @if (old('organizer')) @if (in_array(3,old('organizer'))) checked @endif @endif>Taiwan
                                            Startup Stadium 台灣新創競技場</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input name="organizer[]" type="checkbox" value="4"
                                                      @if (old('organizer')) @if (in_array(4,old('organizer'))) checked @endif @endif>500
                                            Startups</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input name="organizer[]" type="checkbox" value="5"
                                                      @if (old('organizer')) @if (in_array(5,old('organizer'))) checked @endif @endif>TRIPLE
                                            快製中心</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input name="organizer[]" type="checkbox" value="6"
                                                      @if (old('organizer')) @if (in_array(6,old('organizer'))) checked @endif @endif>tvca
                                            中華民國創業投資商業同業協會</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input name="organizer[]" type="checkbox" value="7"
                                                      @if (old('organizer')) @if (in_array(7,old('organizer'))) checked @endif @endif>Seinsights
                                            社企流</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input name="organizer[]" type="checkbox" value="8"
                                                      @if (old('organizer')) @if (in_array(8,old('organizer'))) checked @endif @endif>Fugle
                                            群馥科技</label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="organizer[]" type="checkbox" value="999"
                                                   @if (old('organizer')) @if (in_array(999,old('organizer'))) checked @endif @endif>Other
                                            <input type="text" name="organizer-field" id="organizer-field"
                                                   value="{{old("organizer-field")}}">
                                        </label>
                                    </div>
                                    @if ($errors->has('organizer'))<br><p
                                            class="alert alert-danger">{{ $errors->first('organizer') }}</p> @endif
                                    @if ($errors->has('organizer-field'))<br><p
                                            class="alert alert-danger">{{ $errors->first('organizer-field') }}</p> @endif
                                </div>
                                <div class="form-group  col-md-12">
                                    <h3><label for="questionnaire-quote">值得分享的引述</label></h3>
                                    <p>不記得講師講過什麼特別有趣的話，沒關係，留空白</p>
                                    <input type="text" name="quote" id="questionnaire-quote" class="form-control">
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
    <script>
        $( "button" ).click(function() {
            $( "#eventForm" ).show(1000);
        });
        $( "#eventList").change(function() {
            var option = $(this).val();
            window.location.href = "{{ url('admin/form/review') }}?speakerId={{$eventData['speaker']->id}}&eventId="+option;
        });
        $('.input-group.date').datepicker({
            format: 'mm/dd/yyyy',
        });
    </script>
@endsection