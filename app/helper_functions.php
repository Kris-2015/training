<?php
    
function asset_timed($path)
{

    $return_path = asset( $path );
    $timestamp = filemtime(public_path( $path ));

    return $return_path . '?' . $timestamp;
}