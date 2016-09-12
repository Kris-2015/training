<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\User;
use Auth;

class UpdateFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return User::where('id', Auth::id())
            ->exists();
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
            'email'=> 'required',
            'image' => 'mimes:jpeg,bmp,png|max:6144',
            'homestreet' => 'alpha_spaces',                             
            'homecity' => 'alpha',
            'homestate' => 'alpha',
            'homezip' => 'numeric',
            'homemobile' => 'numeric',
            'homelandline' => 'numeric',
            'homefax' => 'numeric',
            'officestreet' => 'alpha_spaces',
            'officecity' => 'alpha',
            'officestate' => 'alpha',
            'officezip' => 'numeric',
            'officemobile' => 'numeric',
            'officelandline' => 'numeric',
            'officefax' => 'numeric',       
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
