<?php

namespace App\Http\Controllers;
require app_path().'/validators.php';

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Show registration form
     *
     * @param  Request  $request
	*/
	public function register(Request $request)
	{
		$state_list = config('constants.state_list');
		return view('registration', ['state_list' => $state_list]);
	}

	/*
	* processing the form data
	*
	* @param Request $request
	*/
	public function doRegister(Request $request)
	{
		$messages = array(
		'firstname.required' => 'First Name required',
		'firstname.min' => 'Name too short',
		'middlename.alpha' => 'Middle Name should be alphabet',
		'lastname.required' => 'Last Name required',
		'prefix.required' => 'Please select your prefix',
		'gender.required' => 'Please select your gender',
		'marital_status.required' => 'Please enter your marital status',
		'employment.required' => 'Please enter your employment',
		'dob.required' => 'Please enter a valid date of birth',
		'employer.required' => 'Enter the employer name',
		'employer.alpha' => 'Enter alphabet only',
		'email.required' => 'Enter valid email id',
		'password.required' => 'Please give your password',
		'homestreet.required' => 'Please give your residence street address',
		'homecity.required' => 'City name should be in alphabet',
		'homezip.required' => 'Zip code should be in number',
		'homemobile.required' => 'Mobile number should be numeric',
		'homelandline.required' => 'Landline should be numeric',
		'homefax.required' => 'Fax number should be numeric',
		'communication.required' => 'Select anyone mode of communication',
		'homestate.required' => 'Select anyone option from home state',
		'officestreet.required' => 'Please give your office street address',
		'officecity.required' => 'OCity name should be in alphabet',
		'officestate.required' => 'Select anyone option from office state',
		'officezip.required' => 'OZip code should be in number',
		'officemobile.required' => 'OMobile number should be numeric',
		'officelandline.required' => 'OLandline should be numeric',
		'officefax.required' => 'OFax number should be numeric', 
		);

//'homestreet' => 'required|alpha_num',
		$this->validate($request, [
            	'firstname' => 'required|min:10',    
            	'middlename' => 'min:5|alpha',
            	'lastname' => 'required|min:5',
            	'prefix'=>'required',
            	'gender'=>'required',
            	'dob' => 'required',
            	'marital_status' => 'required',
            	'employment' => 'required',
            	'employer'=>'required|alpha',
            	'email'=> 'required|email',
            	'password' =>'required',
            	'image' => 'required|mimes:jpeg,bmp,png|max:6144',
            	'homestreet' => 'required|alpha_spaces',								
            	'homecity' => 'required|alpha',
            	'homestate' => 'required',
            	'homezip' => 'required|numeric',
            	'homemobile' => 'required|numeric|phone_number',
            	'homelandline' => 'required|numeric|phone_number',
            	'homefax' => 'required|numeric|phone_number',
            	'officestreet' => 'required|alpha_spaces',
            	'officecity' => 'required|alpha',
            	'officestate' => 'required',
            	'officezip' => 'required|numeric',
            	'officemobile' => 'required|numeric|phone_number',
            	'officelandline' => 'required|numeric|phone_number',
            	'officefax' => 'required|numeric|phone_number',
            	'communication' => 'required'     	
        	],$messages);


		echo $request->name;
		print_r($request->only('name','email'));

		echo "<pre>";
		print_r($request->all());
		echo "</pre>";
	}
}
