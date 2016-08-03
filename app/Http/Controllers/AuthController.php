<?php

namespace App\Http\Controllers;
require app_path().'/validators.php';

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_activation;
use App\Model\Role;
use Session;
use DB;
use Mail;
use Auth;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


/**
 * Manage Login and registration request
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */

class AuthController extends Controller
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

	/**
	* processing the form data
	*
	* @param Request $request
	*/
	public function doRegister(Request $request)
	{
		$this->validateRequest($request);
		
		$data = $request->all();
		$data[ 'uploaded_image' ] = $this->imageUpload($request);
		
        $user_id = User::insertUser($data);
        
        if($user_id > 0)
        {
           
           $key=$this->GenerateKey($user_id);
           //$data['token'] = $key;
           $this->Email($key);
           return redirect('/login')->with('status', 'We sent you an activation code. Check your email.');
        }
        else
        {
            echo "error occured";
        }
	}

	/**
     * Validating the form
     *
     * @param Request 
    */
	public function validateRequest($request)
	{
		$messages = array(
			'firstname.required' => 'First Name required',
			'firstname.min' => 'Name too short',
			//'middlename.alpha' => 'Middle Name should be alphabet',
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

		$this->validate($request, [
        	'firstname' => 'required',    
        	// 'middlename' => 'alpha',
        	'lastname' => 'required',
        	'prefix'=>'required',
        	'gender'=>'required',
        	'dob' => 'required',
        	'marital_status' => 'required',
        	'employment' => 'required',
        	'employer'=>'required|alpha_spaces',
        	'email'=> 'required',//|unique:users,email
        	'password' =>'required',
        	'image' => 'mimes:jpeg,bmp,png|max:6144',
        	'homestreet' => 'alpha_spaces',								
        	'homecity' => 'alpha',
        	//'homestate' => 'required',
        	'homezip' => 'numeric',
        	'homemobile' => 'numeric|phone_number',
        	'homelandline' => 'numeric',
        	'homefax' => 'numeric',
        	'officestreet' => 'alpha_spaces',
        	'officecity' => 'alpha',
        	//'officestate' => 'required',
        	'officezip' => 'numeric',
        	'officemobile' => 'numeric|phone_number',
        	'officelandline' => 'numeric',
        	'officefax' => 'numeric',
        	'communication' => 'required'     	
    	], $messages);
	}

    /**
     * Function to upload the image
     *
     * @param Request
     *
     * @return image name
    */
	public function imageUpload($request)
	{
		$image_name = $request->file('image')->getClientOriginalName();
		$image_extension = $request->file('image')->getClientOriginalExtension();

		$image_new_name = md5(microtime(true));

		$request->file('image')->move( base_path() . '/public/upload', strtolower($image_new_name . '.' .$image_extension) );
		$name = strtolower($image_new_name . '.' .$image_extension);
		return $name; 
	}

    /**
     * Function to send message
     *
     * @param: activation key
     * @return: none
    */
	public function Email($key)
     {
     	$user = [
     	'name' => 'kris',
     	'email' => 'krishnadev.rnc@gmail.com'
     	];
     	
     	Mail::queue('emails.activate', ['key'=> $key], function ($m) use ($user)
     	{
     		$m->from('kris@app.com', 'Your Application');

     		$m->to($user['email'], $user['name'])->subject('Your Reminder!');
     	});
     }

   /**
	* Show the login page
	*
	* @param  Request  $request
    */
    public function login(Request $request)
    {
    	return view('login');
    }

    /**
    * Processing the login page data
    *
    *  @param  Request  $request
    */
    public function dologin(Request $request)
    {
        $message['email_id.required'] = 'Email id required';
        $message['password.required'] = 'Give your password';

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ], $message);
        
        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password, 'activated'=>'1'])) 
        {
            return redirect('/dashboard');  
        }
        else 
        {
            return redirect('/login')->with('status', 'Invalid email id or password');
        }
    }

    /**
     * Function to perform logout
     *
     * @param Request
     * @return redirect
    */
    public function logout(Request $request)
    {
       // Auth::logout();
        // $request->session()->flush();
        Session::flush();
        return redirect('/login');
    }

    /**
	 * Generate key 
     * @param: none
     *
     * @return: hash 
    */
    public function GenerateKey($id)
    {

        $user = new User();
        $get_user = $user::where('id',$id)->get();
        
        $id = $get_user[0]['id'];
        $name = $get_user[0]['first_name'];
        $key = md5($id.$name);

        $data = array('user_id'=>$id, 'token'=>$key);
        $insert_code = User_activation::insertActivation($data);

        return $key;
    }

    /**
     * Function to activate the users account
     *
     * @param: token number
     * @return: login page with message
    */
    public function activateUser($token)
    {
        $verify = new user_activation();

        $verify = $verify::where('token',$token)->get();
        $user_id = $verify[0]['user_id'];

        if($verify[0]['token'] == $token)
        {
            //update the users table column actiavted to 1
            $user = User::find($user_id);

            $user->activated = '1';
            $user->save();

            return redirect('/login')->with('status', 'your email is verified, please login to access your account.');
        }
    }
}
