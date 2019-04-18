<?php

use Illuminate\Database\Seeder;
use \App\Obj;
use \Illuminate\Support\Facades\DB;

class ObjsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $objs_data = [
            [
                'name' => 'Objektas 1',
                'details' => 'Erfurto g. 56',
                'notes_1' => 'Lorem ipsum dolor sit amet',
                'notes_2' => '',
            ],
            [
                'name' => 'Objektas 2',
                'details' => 'Jonažolių g. 18',
                'notes_1' => 'Lorem ipsum dolor sit amet',
                'notes_2' => 'Lorem ipsum dolor sit amet',
            ],
            [
                'name' => 'Objektas 3',
                'details' => 'Turgaus g. 102',
                'notes_1' => '',
                'notes_2' => 'Lorem ipsum dolor sit amet',
            ],
            [
                'name' => 'Objektas 3',
                'details' => 'Rygos g. 54',
                'notes_1' => 'Lorem ipsum dolor sit amet',
                'notes_2' => 'Lorem ipsum dolor sit amet',
            ],
        ];

        Obj::insert($objs_data);

        $contract_objs_data = [
            [
                'contract_id' => 1,
                'obj_id' => 1,
            ],
            [
                'contract_id' => 1,
                'obj_id' => 2,
            ],
            [
                'contract_id' => 1,
                'obj_id' => 3,
            ],
            [
                'contract_id' => 2,
                'obj_id' => 4,
            ],
        ];

        DB::table('contract_obj')->insert($contract_objs_data);

        $obj_research_areas_data = [
            [
                'obj_id' => 1,
                'research_area_id' => 2,
            ],
            [
                'obj_id' => 1,
                'research_area_id' => 3,
            ],
            [
                'obj_id' => 1,
                'research_area_id' => 5,
            ],
            [
                'obj_id' => 2,
                'research_area_id' => 1,
            ],
            [
                'obj_id' => 2,
                'research_area_id' => 2,
            ],
            [
                'obj_id' => 3,
                'research_area_id' => 2,
            ],
            [
                'obj_id' => 4,
                'research_area_id' => 1,
            ],
            [
                'obj_id' => 4,
                'research_area_id' => 2,
            ],
            [
                'obj_id' => 4,
                'research_area_id' => 3,
            ],
        ];

        DB::table('obj_research_area')->insert($obj_research_areas_data);
    }
}
