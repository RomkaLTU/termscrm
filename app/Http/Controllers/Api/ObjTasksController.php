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
        $group = ParamGroup::create();
        $group->taskparams()->attach( $request->task_params );
    }

    public function getGroup()
    {
        return ParamGroup::all()->pluck('taskparams', 'id');
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
}
