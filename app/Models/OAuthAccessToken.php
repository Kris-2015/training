<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

class OAuthAccessToken extends Model
{
    protected $table = 'oauth_access_tokens';

    public static function insertToken($data)
    {   
        try   
        {
            $access_token = new OAuthAccessToken();

            $access_token->oauth_client_id = $data['serial_no'];
            $access_token->token = $data['token'];
            $inserted_data = $access_token->save();

            $data['token_id'] = $access_token->id;
            
            // On successful insert return the id of token
            if ( $inserted_data )
            {
                return $data['token_id'];
            }

            throw new Exception("Database Error: Error occured while inserting access_token data");
        }
        catch (\Exception $e)
        {
            // Logging error 
            errorReporting($e);
            return 0;
        }
    }
}
