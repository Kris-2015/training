<?php

/*
 * This file is part of Laravel Instagram.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Instagram Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [

        'main' => [
            'id' => '926bd1f60e1b4afc8ecc72d598716488',
            'secret' => 'b4e4919d6f154c8d888edc39e1bf83cc',
            'access_token' => null,
        ],

        'alternative' => [
            'id' => env('CLIENT_ID', 'kris_9301'),
            'secret' => env('CLIENT_SECRET', '0000'),
            'access_token' => null,
        ],

    ],

];
