<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

/**
 * Manages the Google map api request
*/
class MapController extends Controller
{
    /**
     * 
    */
    public function map(Request $request)
    {
        return view('map');
    }
}
