<?php

use Illuminate\Database\Seeder;

class OAuthClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the website clients

        \App\Models\OAuthClient::create([
        	'id' => 'a53108f7543b75adbb34afc035d4cdf6',
        	'secret' => '471c393a47486f23e6830ce8ec630aa6',
        	'name' => 'Website'
        ]);
    }
}
