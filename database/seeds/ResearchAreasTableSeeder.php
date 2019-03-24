<?php

use Illuminate\Database\Seeder;

class ResearchAreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\ResearchArea::create([
            'name' => 'Orai'
        ]);
        \App\ResearchArea::create([
            'name' => 'Nuotekos'
        ]);
        \App\ResearchArea::create([
            'name' => 'Geriamas vanduo'
        ]);
        \App\ResearchArea::create([
            'name' => 'Geologija'
        ]);
        \App\ResearchArea::create([
            'name' => 'Rasto darbai'
        ]);
        \App\ResearchArea::create([
            'name' => 'Kita'
        ]);
    }
}
