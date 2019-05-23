<?php

use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Region::insert(
            [
                ['name' => 'Alytaus apskr.'],
                ['name' =>  'Kauno apskr.'],
                ['name' =>  'Klaipėdos apskr.'],
                ['name' =>  'Marijampolės apskr.'],
                ['name' =>  'Panevėžio  apskr.'],
                ['name' =>  'Šiaulių apskr.'],
                ['name' =>  'Tauragės apskr.'],
                ['name' =>  'Telšių apskr.'],
                ['name' =>  'Utenos apskr.'],
                ['name' =>  'Vilniaus apskr.'],
            ]
        );
    }
}
