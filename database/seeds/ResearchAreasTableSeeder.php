<?php

use Illuminate\Database\Seeder;
use \App\ResearchArea;

class ResearchAreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Orai'],
            ['name' => 'Nuotekos'],
            ['name' => 'Geriamas vanduo'],
            ['name' => 'Geologija'],
            ['name' => 'Rasto darbai'],
            ['name' => 'Kita'],
        ];

        ResearchArea::insert($data);
    }
}
