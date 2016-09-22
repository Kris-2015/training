/**
 * Name: Profile.js  file 
 * Purpose: Profile of the user ( Personal Profile, Github, Edit and Delete) 
 * Package: public/js
 * Created On: 20th July, 2016
 * Author: msfi-krishnadev
*/

profile = {

    global : function() {
        $(document).on('click', '.pro', function() {
            var user_id = $(this).data("id");
           
            $.ajax({
                url: 'datatables/user',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: user_id,
                },
                success:function(response)
                {
                    //map url from hidden input field with id path
                    var url = $('.path').val();
                    
                    // Print the profile information in html
                    $("#profile_name").html("<strong>Name:</strong> "+ response[0].first_name+ ' ' +
                    response[0].last_name);
                    $("#profile_dob").html("<strong>DOB:</strong> "+ response[0].dob);
                    $("#profile_gender").html("<strong>Gender:</strong> "+response[0].gender);
                    $("#profile_prefix").html("<strong>Prefix:</strong> "+response[0].prefix);
                    $("#profile_email").html("<strong>Email:</strong> "+ response[0].email);
                    $("#profile_github").html("<strong>Github Id: </strong>"+ response[0].github_id);
                    $(".profile_pic").html('<img src=/upload/'+response[0].image+' width="150px" height="150px">');
                    $("#location").html('<strong>Location:</strong><a href="'+url+'?user='+
                        response[0].userId+'" target="_blank">View Map</a>');
                }   
            });

            $("#profile").modal({
                backdrop: 'static',
                keyboard: 'false'
            }, 'show');
       });

       // Function is used to display Github Information
       $(document).on('click', '.git', function(){

            // Get github id of user
            var github_name = $(this).data("github");

            // Removing previously defined css loader
            $(".loader-container").removeClass('hidden');
            $(".github-container").addClass('hidden');
            $(".git_name").html('Loading Github Profile ');

            $.ajax({
                url:'datatables/git',
                type: 'POST',
                dataType: 'json',
                data:{
                    gitid:github_name,
                },
                success:function(response)
                {
                    // Add a css loader to display loading as a sign of wait
                    $(".loader-container").addClass('hidden');
                    $(".github-container").removeClass('hidden');

                    // Loading the github information of user
                    $(".git_name").html('Github Profile of <strong>' + response.name + '</strong>');
                    $(".image").html('<img src="' + response.avatar_url + '"id="image" height="150px" width="150px"/>');
                    $("#git_login").html('<strong id="log">Login Id: </strong>' + '<a href="' + response.html_url +
                    '" target="_blank">' + response.login + '</a>');
                    $("#git_location").html('<strong>Location: </strong>' + response.location);
                    $("#git_repositories").html('<strong>Number of repositories: </strong>' + response.public_repos);
                    $("#git_follower").html('<strong>Follower: </strong>' + response.followers);
                    $("#git_following").html('<strong>Following: </strong>' + response.following);
                }
            });

            $("#github").modal({
                backdrop: 'static',
                keyboard: 'false'
            }, 'show');
       });

        $(document).on('click', '.delete', function(){

          var id = $(this).data("id");

          $(".del").attr("data-id", id);
          
          $("#delete").modal({
              backdrop: 'static',
              keyboard: 'false'
          }, 'show');
       });

        $(document).on('click', '.del', function(){

            var user_id = $(this).attr("data-id");

            deleteUser( user_id );
        });
    }
}

function changeActivationStatus ( btn ) {
    var btnObj = $( btn );

    var activate = btnObj.attr('data-activate');
    var id = btnObj.attr('data-id');
    
    if( activate === '0' )
    {
        $(".del").attr("data-id", id);
        $("#delete").modal({
            backdrop: 'static',
            keyboard: 'false'
        }, 'show');
    }
    else
    {
        // Make AJAX call to activate the user
        $.ajax({
            url:'activate',
            type: 'POST',
            dataType: 'json',
            data:{
                id:id,
            },
            success:function(response)
            {
                $('#users-table').DataTable().ajax.reload();
            }
        });
    }
}

function deleteUser (user_id) {
    $.ajax({
        url:'delete',
        type: 'POST',
        dataType: 'json',
        data:{
            id:user_id,
        },
        success:function(response)
        {
            $('#delete').modal('hide');
            $('#users-table').DataTable().ajax.reload();
        }
    });
}

profile.global();