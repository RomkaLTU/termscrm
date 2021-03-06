<?php

namespace App\Http\Controllers\Api;

use App\ParamGroup;
use App\TaskParam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ObjTasksController extends Controller
{
    public function createParam( Request $request )
    {
        $tag = TaskParam::where('name', $request->name)->first();

        if ( $tag ) {
            return [];
        }

        return TaskParam::create([
            'name' => $request->name,
        ]);
    }

    public function createGroup( Request $request )
    {
        $request->validate([
            'task_params_group_name' => 'required',
            'task_params' => 'required|array|min:1',
        ]);

        $group = ParamGroup::create([
            'name' => $request->task_params_group_name,
        ]);

        $param_ids = [];

        foreach ( $request->task_params as $param ) {
            if ( is_numeric($param) ) {
                $param_ids[] = $param;
            } else {
                $param_ids[] = TaskParam::where('name', $param)->first()->id;
            }
        }

        $group->taskparams()->attach( $param_ids );
    }

    public function getGroup()
    {
        return ParamGroup::all();
    }

    public function getGroupAll()
    {
        return ParamGroup::all();
    }

    public function deleteGroup( $group_id )
    {
        $group = ParamGroup::find($group_id);

        if ( $group ) {
            $group->delete();
        }
    }

    public function get_params(Request $request)
    {
        return TaskParam::whereHas('researchAreas', function($q) use ($request){
            $q->where('research_area_id', $request->ra);
        })->get();
    }
}
