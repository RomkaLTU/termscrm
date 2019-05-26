<?php

namespace App\Console\Commands;

use App\ObjTask;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class CheckTasksExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check tasks expiration';

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
        $all_tasks_ids = ObjTask::all()->pluck('id')->toArray();

        $late_query = ObjTask::whereHas('contract', function($q){
            $q->where('contract_status','galiojanti');
        })->where( function($q) {

            // Liko 5 dienas arba jau veluoja
            $q->orWhere( function($qq) {
                $qq->whereBetween('due_date', [ Carbon::now(), Carbon::now()->addDay(5) ]);
            } );
            $q->orWhere( function($qq) {
                $qq->whereDate('due_date', '<=', Carbon::now());
            } );

        } );

        $late_tasks_ids = $late_query->pluck('id')->toArray();

        $indexes_to_remove = array_keys(array_intersect($all_tasks_ids, $late_tasks_ids));
        $tasks_not_late = array_values(Arr::except($all_tasks_ids, $indexes_to_remove));

        ObjTask::whereIn('id', $tasks_not_late)->update([
            'late' => 0,
        ]);

        $late_query->update([
            'late' => 1,
        ]);

        //dump($tasks_not_late);

        return false;
    }
}
