<?php

namespace App\Http\Controllers\Api;

use App\ObjTask;
use App\TaskVisit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskVisitsController extends Controller
{
    public function visits( Request $request )
    {
        foreach ( $request->checked as $checked ) {

            $task = ObjTask::find($checked);

            if ( !empty($task->requiring_int) ) {
                $this->setRequiringDate($task);
            }

            TaskVisit::create([
                'task_id' => $checked,
                'user_id' => $request->user_id,
                'date' => Carbon::now(),
            ]);
        }
    }

    public function get_visits( $task_id )
    {
        return TaskVisit::with(['task','user'])->where('task_id', $task_id)->get();
    }

    /**
     * @param $request
     * @param $task
     */
    private function setRequiringDate($task)
    {
        $current_day_of_month = Carbon::now()->format('d');
        $current_month_middle = Carbon::now()->startOfMonth()->addDay(intval(Carbon::now()->daysInMonth / 2))->format('Y-m-d');
        $current_month_last_day = Carbon::now()->endOfMonth()->format('Y-m-d');
        $current_last_of_quarter = Carbon::now()->lastOfQuarter()->format('Y-m-d');
        $middle_of_current_year = Carbon::now()->year . '-06-15';

        switch ($task->requiring_int)
        {
            case '2k. / mėn.':
                if ( $current_day_of_month <= $current_month_middle ) {
                    $due_date = $current_month_middle;
                } else {
                    $due_date = $current_month_last_day;
                }

                $task->update([
                    'due_date' => $due_date,
                ]);

                break;

            case '1k. / mėn.':
                $task->update([
                    'due_date' => $current_month_last_day,
                ]);
                break;

            case '1k. / ketv.':
                $task->update([
                    'due_date' => $current_last_of_quarter,
                ]);
                break;

            case '2k. / met.':
                if ( Carbon::now()->format('Y-m-d') < $middle_of_current_year ) {
                    $due_date = $middle_of_current_year;
                } else {
                    $due_date = Carbon::now()->endOfYear()->format('Y-m-d');
                }

                $task->update([
                    'due_date' => $due_date,
                ]);
                break;

            case '1k. / met.':
                $task->update([
                    'due_date' => Carbon::now()->endOfYear()->format('Y-m-d'),
                ]);
                break;
        }
    }
}
