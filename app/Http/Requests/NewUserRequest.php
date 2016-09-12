<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class NewUserRequest extends Request
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
            'email'=> 'required',
            'password' =>'required'
        ];
    }

    public function messages ()
    {
        return array(
            'firstname.required' => 'First Name required',
            'firstname.min' => 'Name too short',
            'lastname.required' => 'Last Name required',
            'email.required' => 'Enter valid email id',
            'password.required' => 'Please give your password'
        );
    }
}
