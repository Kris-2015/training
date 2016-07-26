<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Employee;
use DB;

class EmployeeController extends Controller
{
	/*
	 * Show a list of all employees
	*/
    public function index()
    {
    	$emp = DB::select('SELECT * FROM employee WHERE role_id=?',[1]);
    }
}
