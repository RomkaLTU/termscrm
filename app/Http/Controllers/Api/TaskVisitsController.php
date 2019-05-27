<?php

namespace App\Http\Controllers\Api;

use App\TaskVisit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskVisitsController extends Controller
{
    public function visits( Request $request )
    {
        foreach ( $request->checked as $checked ) {
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
}
