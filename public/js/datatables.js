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
        bStateSave: true,
        ajax: url,
        columns: [
            { data: 'first_name', name: 'first_name' },
            { data: 'email', name: 'email' },
            { data: 'dob', name:'dob'},
            { data: 'created_at', name:'users.created_at'},
            { data: 'updated_at', name:'users.updated_at'},
            { data: 'action', name: 'action', orderable: false, searchable: false},
            { data: 'status', name: 'status', orderable:false, searchable: false}
        ],
        fnStateSave: function(settings, data) {
            localStorage.setItem( 'DataTables' + JSON.stringify(data) );
        },
        fnStateLoad: function(settings) {
            return JSON.parse( localStorage.getItem( 'Datatables') );
        }
    });

    var user = table.on( 'xhr', function() { 
        json_data = table.ajax.json();

    });
});