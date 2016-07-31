@extends('layouts.app')

@section('title', 'dashboard')

@section('page')
<a href="/register"><span class="glyphicon glyphicon-user"></span>Registration</a>
@endsection

@section('content')
    <div class="container">
        <div class=" col-sm-12">
            <table class="table table-bordered" id="user-table">
            	<thead>
            		<tr>
            			<th>Name</th>
            			<th>Gender</th>
            			<th>DOB</th>
            			<th>Email</th>
            			<th>Marital Status</th>
            			<th>Image</th>
            			<th>City</th>
            			<th>State</th>
            			<th>Communication</th>
            		</tr>
            	</thead>
            	<tbody>
            	@foreach($information as $userlist)
          		  <tr>
          		  	 <td>{{$userlist->first_name . ' ' . $userlist->last_name}}</td>
          		  	 <td>{{ $userlist->gender }}</td>
          		  	 <td>{{ $userlist->dob }}</td>
          		  	 <td>{{ $userlist->email }}</td>
          		  	 <td>{{ $userlist->marital_status }}</td>
          		  	 <td><img src='upload/{{$userlist->image}}' width='45' height='45'></td>
          		  	 <td>{{ $userlist->city }}</td>
          		  	 <td>{{ $userlist->state }}</td>
          		  	 <td>{{ $userlist->type }}</td>
          		  </tr>
          		@endforeach
          		</tbody>
            </table>
        </div>
    </div>
@endsection

