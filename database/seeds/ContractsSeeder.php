<?php

use App\Obj;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \App\Contract;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ContractsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i < 20; $i++) {
            $contract_objs_data = [];

            $contract = Contract::create([
                'contract_nr' => 'LT' . $faker->unique()->numberBetween(1000,9999),
                'customer' => $faker->name,
                'customer_address' => $faker->address,
                'contract_status' => 1,
                'validity' => 'todate',
                'validity_extend_till_value' => null,
                'validity_value' => $faker->dateTimeBetween('+1 months', '+6 months'),
                'validity_verbal' => $faker->boolean,
                'contract_value' => $faker->numberBetween(1000,50000),
            ]);

            for($ii = 1; $ii < $faker->numberBetween(5,30); $ii++) {
                $obj = Obj::create([
                    'name' => 'Objektas ' . $ii,
                    'details' => $faker->streetAddress,
                    'notes_1' => $faker->sentence,
                    'notes_2' => '',
                ]);

                $contract_objs_data[] =  [
                    'contract_id' => $contract->id,
                    'obj_id' => $obj->id,
                ];
            }

            DB::table('contract_obj')->insert($contract_objs_data);
        }

        $contract_invoices_data = [
            [
                'contract_id' => 1,
                'total' => '400',
                'status' => 1,
                'due_date' => '2019-04-01',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'contract_id' => 1,
                'total' => '600',
                'status' => 0,
                'due_date' => '2019-04-01',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
        ];

        DB::table('contract_invoices')->insert($contract_invoices_data);
    }
}
