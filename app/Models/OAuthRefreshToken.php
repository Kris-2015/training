<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

class OAuthRefreshToken extends Model
{
	protected $table = 'oauth_refresh_tokens';

    /**
	 * Function to insert token id, life span, expire time
	 * 
	 * @param: data
	 * @return: integer 
    */
    public static function insertDetails($lifespan)
    {
    	try
    	{
    		$expire_token = new OAuthRefreshToken();

    		$expire_token->access_token_id = $lifespan['access_token_id'];
    		$expire_token->token_life = $lifespan['token_life'];
    		$expire_token->expire_time = $lifespan['expire_time'];
    		$insertion_successful = $expire_token->save();

    		if ( $expire_token )
    		{
    			return 1;
    		}
    		
    		throw new \Exception('Database Error: Error occured while inserting records in OAuthRefreshToken');
    	}
    	catch(\Exception $e)
    	{
    		errorReporting($e);
    		return 0;
    	}

    }

}
