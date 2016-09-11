/**
 * Name: Map.js  file 
 * Purpose: Admin panel of user  
 * Package: public/js
 * Created On: 28th July, 2016
 * Author: msfi-krishnadev
*/

var panel =  {

    /*
     * Function which contains all DOM event function
     *
     * @param: void
     * @return: void
    */
    global: function() {
        $(document).ready(function() {
            panel.display();

            // Send the request to get the privilege
            $(document).on('change', '.role, .resource', function() {

                var get_role = $('.role').val();
                var get_resource = $('.resource').val();
                panel.getPrivilege(get_role, get_resource);

            });

            //Set the permission for the resource on the basis of role
            $(document).on('change', '.privilege input[type="checkbox"]', function() {

                // Get the new data given by admin
                var set_role = $('.role').val();
                var set_resource = $('.resource').val();
                var set_privilege = $(this).val(); 
                var action;

            //if the checkbox is checked, then set action variable to add otherwise delete
            if ($(this)[0].checked) {

                action = 'add';

                } else {

                action = 'delete';

                }

                // Calling set function to set new role, resource and privileges of user
                panel.setPermission(set_role, set_resource, set_privilege, action);
            });
        });
    },

    /**
     * function for printing the role, resource and privileges
     * @param:void
     * return: void
    */
    display: function() {
       $.ajax({
          url: 'panel/getAuthorisationDetails',
          type: 'POST',
          success: function(data) {

             var role = resource = privilege = " ", key;

             // Iterating to display dropdown menu of role of user
             for (key in data.role) {
                if (data.role.hasOwnProperty(key)) {
                   role += '<option id="' + data.role[key]['role_name'] + '" value="' + 
                   data.role[key]['role_id'] + '">' + data.role[key]['role_name'] + '</option>';
                }
             }

             // Iterating to display dropdown menu of resource of user
             for (key in data.resource) {
                if (data.resource.hasOwnProperty(key)) {
                   resource += '<option id="' + data.resource[key]['resource_name'] + '" value="' 
                   + data.resource[key]['resource_id'] + '">' + data.resource[key]['resource_name'] + '</option>';
                }
             }

             // Iterating to create the checkbox of permission of the resource
             for (key in data.permission) {
                if (data.permission.hasOwnProperty(key)) {
                   privilege += '<label class="checkbox-inline"><input type="checkbox" id="' + 
                   data.permission[key]['name'] + '" value="' + data.permission[key]['permission_id'] + '">' 
                   + data.permission[key]['name'] + '</label>';
                }
             }

             //Printing the data to the html based on classes
             $(".role").html(role);
             $(".resource").html(resource);
             $(".privilege").html(privilege);
          }
       });
    },

    /**
     * Function to select the privilege checkbox
     * @param: role_id and resource_id
     * @return: void
    */
    getPrivilege: function(get_role, get_resource) {
        $.ajax({
            url: 'panel/permission',
            type: 'POST',
            dataType: 'json',
            data: {
            role: get_role,
            resource: get_resource,
            },
            success: function(response) {

                $('.privilege input[type="checkbox"]').each(function() {
                var checkbox_obj = $(this);

                //uncheck all the previously checked checkbox
                checkbox_obj.prop('checked', false);


                $.each(response, function(resp_key, resp_data) {
                   if (checkbox_obj.val() === resp_data.permission_id) {

                      //check the checkbox as per permission
                      checkbox_obj.prop('checked', true);
                        }
                    });
                });
            }
        });
    },

    /**
     * Function to set permission
     * @param: role_id,resource_id,privilege_id, action
     * @return: void
    */
    setPermission: function(get_role, get_resource, get_privilege, action) {
     $.ajax({
         url: 'panel/setpermission',
         type: 'POST',
         dataType: 'json',
         data: {
             role: get_role,
             resource: get_resource,
             permission: get_privilege,
             action: action,
         },
         success: function(response) {
         
                $('.user-alert').fadeIn('fast').delay(2000).fadeOut('fast');
            }
        });
    }
};

panel.global();