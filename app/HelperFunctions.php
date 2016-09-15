<?php
use Illuminate\Support\Facades\Log;


/**
  * Function is used for versioning the css and js files
  *
  * @param path of css and js file
  * @return updated version of files
 */  
function asset_timed($path)
{

    $return_path = asset( $path );
    $timestamp = filemtime(public_path( $path ));

    return $return_path . '?' . $timestamp;
}

/**
  * Function is used for logging error
  *
  * @param error message
  * @return void
 */
function errorReporting($error)
{
	Log::error($error);
}

/**
 * Function is use to generate encrypted value
 *
 * @param: void
 * @return: hash
*/
function token()
{
    $token_genrator = md5(microtime());

    return $token_genrator;
}

/**
 * Function is use to generate client Id
 *
 * @param: void
 * @return: hash
*/
function clientId()
{
    $client_id = md5(microtime());

    return $client_id;
}

function secretId()
{
    $client_secret = md5(microtime());

    return $client_secret;    
}