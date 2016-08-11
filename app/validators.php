<?php
    /** @var \Illuminate\Validation\Factory $validator */

    $validator->extend('alpha_spaces', function($attribute, $value)
    {
        return preg_match('/^[a-zA-Z0-9-,\s]*$/', $value);    // /^[a-zA-Z\s]*$/ or [a-zA-Z0-9, ]
    });

    $validator->extend('phone_number', function($attribute, $value)
    {
        return preg_match('/[0-9]{10}/', $value);
    });

    
/*
* add the validators.php file in start/global.php: require app_path().'/validators.php'
* and use it as usual:  $rules = array('name' => 'required|alpha_spaces',);
*/
?>