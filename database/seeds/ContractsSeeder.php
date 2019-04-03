<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \App\Contract;

class ContractsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'contract_nr' => 'LT0001',
                'customer' => 'Jack Doe',
                'customer_address' => 'Baker Street, 221B',
                'contract_status' => 'galiojanti',
                'validity' => 'todate',
                'validity_extend_till_value' => null,
                'validity_value' => '2019-11-16',
                'validity_verbal' => 0,
                'contract_value' => '4000'
            ],
            [
                'contract_nr' => 'LT0002',
                'customer' => 'Mary Jane',
                'customer_address' => 'Clinton St., Apt. #3B',
                'contract_status' => 'galiojanti',
                'validity' => 'todate',
                'validity_extend_till_value' => null,
                'validity_value' => '2019-11-16',
                'validity_verbal' => 1,
                'contract_value' => '12000'
            ],
        ];

        Contract::insert($data);

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
