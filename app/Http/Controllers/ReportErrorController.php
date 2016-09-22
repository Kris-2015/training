<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ReportErrorController extends Controller
{
    public function reportError(Request $request)
    {
        // Logging error of failed ajax calls
        $error = $request->all();
        
        errorReporting($error);
    }
}
