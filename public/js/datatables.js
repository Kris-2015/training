/**
 * Name: Datatables.js  file 
 * Purpose:  
 * Package: public/js
 * Created On: 25th Aug, 2016
 * Author: msfi-krishnadev
*/

var json_data, url;

$(document).ready(function() {

    url = $('#url').val();

    var table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu:[2,5,10],
        ajax: url,
        columns: [
            { data: 'first_name', name: 'first_name' },
            { data: 'email', name: 'email' },
            { data: 'dob', name:'dob'},
            { data: 'created_at', name:'created_at'},
            { data: 'updated_at', name:'updated_at'},
            { data: 'action', name: 'action', orderable: false, searchable: false},
            { data: 'status', name: 'status', orderable:false, searchable: false}
        ]
    });

    var user = table.on( 'xhr', function() { 
        json_data = table.ajax.json();
    });
});