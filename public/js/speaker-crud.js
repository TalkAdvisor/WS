$(document).ready(function(){

    var url = "/speaker";

    //display modal form for speaker editing
    $('.open-modal').click(function(){
        var speaker_id = $(this).val();

        $.get(url + '/' + speaker_id, function (data) {
            //success data
            console.log(data);
            $('#speaker_id').val(data.id);
            $('#task').val(data.task);
            $('#description').val(data.description);
            $('#btn-save').val("update");

            $('#myModal').modal('show');
        })
    });

    //display modal form for creating new speaker
    $('#btn-add').click(function(){
        $('#btn-save').val("add");
        $('#speakerForm').trigger("reset");
        $('#gridSystemModal').modal('show');
    });

    //delete speaker and remove it from list
    $('.delete-task').click(function(){
        var speaker_id = $(this).val();

        $.ajax({

            type: "DELETE",
            url: url + '/' + speaker_id,
            success: function (data) {
                console.log(data);

                $("#task" + speaker_id).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    //create new speaker / update existing speaker
    $("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        e.preventDefault(); 

        var formData = {
            talker_name: $('#talker-name').val(),
            talker_en_name: $('#talker-en-name').val(),
            talker_company: $('#talker-company').val(),
            talker_title: $('#talker-title').val(),
            talker_lang: $('#talker-lang').val(),
            talker_description: $('#talker-description').val(),
            talker_email: $('#talker-email').val(),
            talker_image: $('#talker-image').val()
        }        
        
        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();

        var type = "POST"; //for creating new resource
        var speaker_id = $('#speaker_id').val();
        var my_url = url;

        if (state == "update"){
            type = "PUT"; //for updating existing resource
            my_url += '/' + speaker_id;
        }

        console.log(formData);

        $.ajax({

            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);

                /*var task = '<tr id="task' + data.id + '"><td>' + data.id + '</td><td>' + data.task + '</td><td>' + data.description + '</td><td>' + data.created_at + '</td>';
                task += '<td><button class="btn btn-warning btn-xs btn-detail open-modal" value="' + data.id + '">Edit</button>';
                task += '<button class="btn btn-danger btn-xs btn-delete delete-task" value="' + data.id + '">Delete</button></td></tr>';

                if (state == "add"){ //if user added a new record
                    $('#tasks-list').append(task);
                }else{ //if user updated an existing record

                    $("#task" + speaker_id).replaceWith( task );
                }*/

                $('#speakerForm').trigger("reset");

                $('#gridSystemModal').modal('hide');
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});