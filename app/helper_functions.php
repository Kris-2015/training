<?php
 use Log;
   
function asset_timed($path)
{

    $return_path = asset( $path );
    $timestamp = filemtime(public_path( $path ));

    return $return_path . '?' . $timestamp;
}

function errorReporting($error)
{
	Log::error($error);
}