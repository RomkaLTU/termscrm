<?php

namespace App\Http\Controllers\Api;

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
}
