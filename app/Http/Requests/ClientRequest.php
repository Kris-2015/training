<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ClientRequest extends Request
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
            'app_url' => 'required',
            'email' => 'required'
        ];
    }

    public function messages ()
    {
        return array(
            'app_url.required' => 'Enter your application url',
            'email.required' => 'Email is needed for verification'
        );
    }
}
