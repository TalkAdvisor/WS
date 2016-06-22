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
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-sm-10">
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
                    </div>
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
                            <div id="speakerSection" class=" form-group col-md-12">
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
                            <div id="seriesSection" class="form-group  col-md-12">
                                <h3><label for="questionnaire-series">如果本次演講或者活動屬於一個系列，請填寫此系列的名稱</label></h3>
                                <p>例如：『與創業達人有約』</p>
                                <input type="text" name="series" id="questionnaire-series" autocomplete="off" spellcheck="false" class="form-control typeahead tt-query" value="{{old('series')}}">
                                <input type="hidden" name="series-id" id="series-id" value="{{old('series-id')}}"> 
                            </div>
                            <div id="eventSection" class="form-group  col-md-12">
                                <h3><label for="questionnaire-event">如果本次演講屬於較大的活動，請填寫此活動的名稱</label></h3>
                                <p>例如：創業小聚：第62場</p>
                                <input type="text" name="event" id="questionnaire-event" autocomplete="off" spellcheck="false" class="form-control typeahead tt-query" value="{{old('event')}}">
                                <input type="hidden" name="event-id" id="event-id" value="{{old('event-id')}}">  
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
                            <div id="location" class="form-group  col-md-12">
                                <h3><label for="questionnaire-location">演講詳細地點</label></h3>
                                <p></p>
                                @foreach ($locations as $location)
                                <div class="checkbox">
                                    <label><input name="location[]" type="checkbox" value={{$location->id}} @if (old('location')) @if (in_array($location->id,old('location'))) checked @endif @endif>{{$location->name}}</label><br>
                                </div>
                                @endforeach
                                @if ($errors->has('location'))<br><p
                                        class="alert alert-danger">{{ $errors->first('location') }}</p> @endif
                                @if ($errors->has('location-field'))<br><p
                                        class="alert alert-danger">{{ $errors->first('location-field') }}</p> @endif
                            </div>
                            <div id="organizer" class="form-group  col-md-12">
                                <h3><label for="questionnaire-organizer">演講主辦單位</label></h3>
                                <p></p>
                                @foreach ($organizers as $organizer)
                                <div class="checkbox">
                                    <label><input name="organizer[]" type="checkbox" value={{$organizer->id}} @if (old('organizer')) @if (in_array($organizer->id,old('organizer'))) checked @endif @endif>{{$organizer->name}}</label><br>
                                </div>
                                @endforeach
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
                </div>
            </div>
        </div>
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
        var events = {!!json_encode($events)!!};
        var series = {!!json_encode($series)!!};
        console.log(events);
        speakers = new Bloodhound({
          datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.speaker_name); },
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          // `states` is an array of state names defined in "The Basics"
          local: speakers
        });

        events = new Bloodhound({
          datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          // `states` is an array of state names defined in "The Basics"
          local: events
        });

        series = new Bloodhound({
          datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          // `states` is an array of state names defined in "The Basics"
          local: series
        });


        $('#speakerSection input.typeahead').typeahead({
          minLength: 1,
          highlight: true,
          hint: true
        },
        {
          name: 'speakers',
          source:  speakers.ttAdapter(),
          displayKey: 'speaker_name'
        });

        $('#eventSection input.typeahead').typeahead({
          minLength: 1,
          highlight: true,
          hint: true
        },
        {
          name: 'events',
          source:  events.ttAdapter(),
          displayKey: 'name'
        });

        $('#seriesSection input.typeahead').typeahead({
          minLength: 1,
          highlight: true,
          hint: true
        },
        {
          name: 'series',
          source:  series.ttAdapter(),
          displayKey: 'name'
        });

        $('#speakerSection input.typeahead').bind('typeahead:select', function(ev, suggestion) {
            $(this).parent().parent().children('input[type= "hidden"]').val(suggestion.id);
        });

        $('#eventSection input.typeahead').bind('typeahead:select', function(ev, suggestion) {
            var url = "/event";
            $.ajax({
                type: 'GET',
                url: url+'/'+suggestion.id+'/details',
                success: function (data) {
                    /*var $radios = $('input:radio[name=location]');
                    if($radios.is(':checked') === false) {
                        $radios.filter('[value='+suggestion.id+']').prop('checked', true);
                    }*/
                    $('#organizer :checked').removeAttr('checked');
                    $('#location :checked').removeAttr('checked');
                    var organizers = data.organizers;
                    var locations = data.locations;
                    console.log(data);
                    for(var i = 0; i < organizers.length;i++) {
                        $('#organizer :checkbox[value="'+organizers[i].id+'"]').prop('checked', 'checked');
                    }
                    for(var i = 0; i < locations.length;i++) {
                        $('#location :checkbox[value="'+locations[i].id+'"]').prop('checked', 'checked');
                    }
                    $('#event-id').val(suggestion.id);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

        $('#seriesSection input.typeahead').bind('typeahead:select', function(ev, suggestion) {
            var url = "/series";
            $.ajax({
                type: 'GET',
                url: url+'/'+suggestion.id+'/details',
                success: function (data) {
                    /*var $radios = $('input:radio[name=location]');
                    if($radios.is(':checked') === false) {
                        $radios.filter('[value='+suggestion.id+']').prop('checked', true);
                    }*/
                    $('#organizer :checked').removeAttr('checked');
                    $('#location :checked').removeAttr('checked');
                    var dEvents = data.events;
                    var organizers = data.organizers;
                    var locations = data.locations;
                    for(var i = 0; i < organizers.length;i++) {
                        $('#organizer :checkbox[value="'+organizers[i].id+'"]').prop('checked', 'checked');
                    }
                    for(var i = 0; i < locations.length;i++) {
                        $('#location :checkbox[value="'+locations[i].id+'"]').prop('checked', 'checked');
                    }
                    $('#series-id').val(suggestion.id);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
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