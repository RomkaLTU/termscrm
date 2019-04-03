<?php

use Illuminate\Database\Seeder;

class DistrictsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Alytaus apskr.'],
            ['name' => 'Kauno apskr.'],
            ['name' => 'Klaipėdos apskr.'],
            ['name' => 'Marijampolės apskr.'],
            ['name' => 'Panevėžio  apskr.'],
            ['name' => 'Šiaulių apskr.'],
            ['name' => 'Tauragės apskr.'],
            ['name' => 'Telšių apskr.'],
            ['name' => 'Utenos apskr.'],
            ['name' => 'Vilniaus apskr.'],
        ];

        \App\District::insert($data);
    }
}
