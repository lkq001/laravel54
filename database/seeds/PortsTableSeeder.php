<?php

use Illuminate\Database\Seeder;

class PortsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory('App\Ports', 50)->create()->each(function($p){
            $p->ports()->save(factory('App\Post')->make());
        });
    }
}
