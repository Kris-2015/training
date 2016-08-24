<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;

class UploadController extends Controller
{
    
    public function upload(Request $request)
    {
        
        //fetch the extension of image
        $image_extension = $request->file('file')->getClientOriginalExtension();

        //encrypted name for image
        $image_new_name = $request->file('file')->getClientOriginalName();
        $image = strtolower($image_new_name . '.' .$image_extension);

        //transferring the image from temporary folder to permanent folder
        $request->file('file')->move( public_path( 'upload') , $image );
        $name = strtolower($image_new_name . '.' .$image_extension);


        if(!empty($name))
        {
            //returning the name of image 
            return 'successfully uploaded.';    
        }
        else
        {
            return 'could not upload!!';
        
        } 

    }
}