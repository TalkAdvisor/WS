@extends('layouts.admin')

@section('content')
    <div id="page-wrapper">

        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Talk
                        <small>Subheading</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i>  <a href={{url('admin/dashboard')}}>Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-comment-o"></i> Talk
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
                        <div class="col-sm-9">
                            <h2>Talk</h2>
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" class="btn btn-default" id="btn-addSeries">
                                <i class="fa fa-btn fa-plus"></i> Create Series
                            </button>
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" class="btn btn-default" id="btn-addEvent">
                                <i class="fa fa-btn fa-plus"></i> Create Event
                            </button>
                        </div>
                        <div class="col-sm-1">
                            <a href="{{url('admin/talk/create')}}" class="btn btn-default">
                                <i class="fa fa-btn fa-plus"></i> Create Talk
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Topic</th>
                                <th>Event</th>
                                <th>Event_series</th>
                                <th>Date</th>
                                <th>City</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($talks as $talk)
                                <tr>
                                    <td>{{$talk->id}}</td>
                                    <td>{{$talk->topic}}</td>
                                    <td>{{$talk->talk}}</td>
                                    <td>{{$talk->talk_series}}</td>
                                    <td>{{$talk->start_date}}</td>
                                    <td>{{$talk->talk_city}}</td>
                                    <td>{{$talk->talk_location}}</td>
                                    <td>
                                        <div>
                                        <button class="btn btn-info open-modal" name="talk_update" value="{{$talk->id}}" id="btn-update">Update</button>
                                        
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'style' => 'display:inline-block',
                                                'url' => 'talk/'.$talk->id
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
                    {{ $talks->render() }}
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
                        <h4 class="modal-title" id="gridSystemModalLabel">Create Talk</h4>
                    </div>
                    <div class="modal-body">
                        <form action='{{url('talk')}}' id="talkForm" method="POST" class="form-horizontal">
                            {{ csrf_field() }}

                            <div class="form-group  col-md-12">
                                <h3><label for="questionnaire-topic">演講的講題</label></h3>
                                <p>按照演講邀請書上寫的</p>
                                <input type="text" name="topic" id="auto1" class="form-control"
                                       value="{{old('topic')}}">
                                @if ($errors->has('topic'))<br><p
                                        class="alert alert-danger">{{ $errors->first('topic') }}</p> @endif
                            </div>
                            <div class=" form-group col-md-12">
                                <h3><label>演講的講者</label></h3>
                                <div id="firstSpeaker"> 
                                    <input type="text" name="speaker-name[]"  autocomplete="off" spellcheck="false" class="form-control typeahead tt-query"
                                           value="{{old('speaker-name[0]')}}">     
                                           <button name="showSecondField" type="button" class="btn btn-default"><i class="fa fa-btn fa-plus"></i></button>
                                    <input type="hidden" name="speaker-id[]" value="">       
                                </div>       
                                <div id="secondSpeaker" style="display:none;">       
                                    <input type="text" name="speaker-name[]"  autocomplete="off" spellcheck="false" class="form-control typeahead tt-query"
                                           value="{{old('speaker-name[1]')}}">
                                           <button name="hideSecondField" type="button" class="btn btn-default"><i class="fa fa-btn fa-minus"></i></button>
                                    <input type="hidden" name="speaker-id[]" value="">         
                                </div>  
                                @if ($errors->has('speaker-name'))<br><p
                                        class="alert alert-danger">{{ $errors->first('speaker-name') }}</p> @endif              
                            </div>
                            <div class="form-group  col-md-12">
                                <h3><label for="questionnaire-event">如果本次演講屬於較大的活動，請填寫此活動的名稱</label></h3>
                                <p>例如：創業小聚：第62場</p>
                                <input type="text" name="event" id="questionnaire-event" class="form-control" value="{{old('event')}}">
                            </div>
                            <div class="form-group  col-md-12">
                                <h3><label for="questionnaire-series">如果本次演講或者活動屬於一個系列，請填寫此系列的名稱</label></h3>
                                <p>例如：『與創業達人有約』</p>
                                <input type="text" name="series" id="questionnaire-series" class="form-control" value="{{old('series')}}">
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
                                        <input type="radio" name="city" id="city_1" value="1"
                                               @if (old('city') == "1") checked @endif>
                                        台北
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="city" id="city_2" value="2"
                                               @if (old('city') == "2") checked @endif>
                                        新北市
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="city" id="city_3" value="3"
                                               @if (old('city') == "3") checked @endif>
                                        新竹
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="city" id="city_4" value="4"
                                               @if (old('city') == "4") checked @endif>
                                        台中
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="city" id="city_5" value="5"
                                               @if (old('city') == "5") checked @endif>
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
                                                  @if (old('location') == "1") checked @endif>Garage+</label>
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
                                               value="{{old('organizer-field')}}">
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
                                <input type="text" name="quote" id="questionnaire-quote" class="form-control" value="{{old('quote')}}">
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
    <script>
        $('.input-group.date').datepicker({
            format: 'yyyy/mm/dd',
        });
        var field_inex = 0;
    $('button[name="showSecondField"]').click(function(){
        /*$( 'input[name="speaker-name-'+field_inex+'"]' ).clone().prop('name', 'speaker-name-'+parseInt(field_inex+1)).insertAfter( 'button[name="createSpeakerField"]' );
        field_inex = parseInt(field_inex+1);
        console.log(field_inex);*/
        $('#secondSpeaker').show();
    });
    $('button[name="hideSecondField"]').click(function(){
        var secondField = $('#secondSpeaker');
        secondField.find( "input" ).val('');
        secondField.hide();
    });
        var speakers = {!!json_encode($speakers)!!};

        speakers = new Bloodhound({
          datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.speaker_name); },
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          // `states` is an array of state names defined in "The Basics"
          local: speakers
        });

        $('input.typeahead').typeahead({
          minLength: 1,
          highlight: true,
          hint: true
        },
        {
          name: 'my-dataset',
          source:  speakers.ttAdapter(),
          displayKey: 'speaker_name'
        });

        $('input.typeahead').bind('typeahead:select', function(ev, suggestion) {
            $(this).parent().parent().children('input[type= "hidden"]').val(suggestion.id);
        });

    $(document).ready(function(){
        var url = "/talk";
        //display modal form for creating new talk
        $('#btn-add').click(function(){
            $('.alert').remove();
            $('#talkForm').trigger("reset");
            $('#talkForm').attr('action','{{url('talk')}}');
            $('#talkForm').attr('method','POST');
            $('#gridSystemModalLabel').text('Create Talk');
            $('#gridSystemModal').modal('show');
        });


        $('.open-modal').click(function(){
            $('#talkForm').trigger("reset");
            $('.alert').remove();
            var talk_id = $(this).val(); 
            
            $.ajax({
                type: 'GET',
                url: url+'/'+talk_id,
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
                    $('#talkForm').attr('action',url+'/'+talk_id);
                    $('#talkForm').attr('method','POST');
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
    <style type="text/css">
        .typeahead, .tt-hint {
            border: 2px solid #CCCCCC;
            /*border-radius: 8px;*/
            height: 30px;
            line-height: 30px;
            outline: medium none;
            padding: 8px 12px;
            width: 100%;
        }
        .typeahead {
            background-color: #FFFFFF;
        }
        .tt-hint {
            color: #999999;
        }
        .tt-menu {
            background-color: #FFFFFF;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            margin-top: 12px;
            padding: 8px 0;
            width: 100%;
        }
        .tt-suggestion {
            font-size: 24px;
            line-height: 24px;
            padding: 3px 20px;
        }
        .tt-selectable:hover {
            background-color: #0097CF;
            color: #FFFFFF;
            cursor:pointer;
        }
        .tt-suggestion p {
            margin: 0;
        }

        .twitter-typeahead{
            width:90%;
        }
    </style>
@endsection