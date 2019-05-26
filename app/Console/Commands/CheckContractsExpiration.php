<?php

namespace App\Console\Commands;

use App\Contract;
use Illuminate\Console\Command;
use \Carbon\Carbon;
use Illuminate\Support\Arr;

class CheckContractsExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:contracts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check contracts expiration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get contracts wich DDL is less then 2 months
        $all_contract_ids = Contract::all()->pluck('id')->toArray();

        $late_query = Contract::whereContractStatus('galiojanti')->where(function($q){
                $q->orWhere(function($qq){
                    $qq->whereValidityExtended(0)
                        ->whereBetween('validity_value', [ Carbon::now(), Carbon::now()->addMonth(2) ]);
                });
                $q->orWhere(function($qq){
                    $qq->whereValidityExtended(1)
                        ->whereNotNull('validity_extend_till_value')
                        ->whereBetween('validity_extend_till_value', [ Carbon::now(), Carbon::now()->addMonth(2) ]);
                });
                $q->orWhere(function($qq){
                    $qq->whereValidityExtended(0)
                        ->whereDate('validity_value','<=', Carbon::now());
                });
            })
            ->orWhereHas('invoices', function($q) {
                $q->whereStatus(0)
                    ->whereDate('due_date', '<=', Carbon::now())
                    ->orWhereBetween('due_date', [ Carbon::now(), Carbon::now()->addDay(5) ]);
            });

        $late_contract_ids = $late_query->pluck('id')->toArray();

        // get indexes to remove from $all_contract_ids
        $indexes_to_remove = array_keys(array_intersect($all_contract_ids, $late_contract_ids));
        $contracts_not_late = array_values(Arr::except($all_contract_ids, $indexes_to_remove));

        Contract::whereIn('id', $contracts_not_late)->update([
            'late' => 0,
        ]);

        $late_query->update([
            'late' => 1,
        ]);

        return true;
    }
}
