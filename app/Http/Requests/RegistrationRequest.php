<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegistrationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'required|alpha',    
            'lastname' => 'required|alpha',
            'prefix'=>'required',
            'gender'=>'required',
            'dob' => 'required',
            'marital_status' => 'required',
            'employment' => 'required',
            'employer'=>'required|alpha_spaces',
            'email'=> 'required|unique:users,email',
            'password' =>'required',
            'image' => 'mimes:jpeg,bmp,png|max:6144',
            'homestreet' => 'alpha_spaces',                             
            'homecity' => 'alpha',
            'homestate' => 'alpha',
            'homezip' => 'numeric',
            'homemobile' => 'numeric|phone_number',
            'homelandline' => 'numeric',
            'homefax' => 'numeric',
            'officestreet' => 'alpha_spaces',
            'officecity' => 'alpha',
            'officestate' => 'alpha',
            'officezip' => 'numeric',
            'officemobile' => 'numeric|phone_number',
            'officelandline' => 'numeric',
            'officefax' => 'numeric',
            'communication' => 'required'       
        ];
    }

    public function messages ()
    {
        return array(
            'firstname.required' => 'First Name required',
            'firstname.min' => 'Name too short',
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
    }
}
