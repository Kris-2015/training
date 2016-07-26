<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class BioController extends Controller
{
    public function people()
    {
    	$people = ['Krishna','vivek','smruty'];

    	return view('bio',compact('people'));
    }
}
