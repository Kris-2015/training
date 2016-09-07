<?php
 use Log;

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
