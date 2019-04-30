<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Obj;
use App\ObjTask;
use App\ResearchArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TasksController extends Controller
{
    public function index( Contract $contract, Obj $object )
    {
        return view('tasks.index', [
            'contract' => $contract,
            'obj' => $object,
        ]);
    }

    public function create( Contract $contract, Obj $object )
    {
        return view('tasks.create', [
            'contract' => $contract,
            'obj' => $object,
            'research_areas' => ResearchArea::all(),
        ]);
    }

    public function store( Request $request )
    {
        try {

            $task = ObjTask::create( $request->except('_token', 'research_area','deadline') );

        } catch (\Exception $e) {

            Session::flash('error', $e->getMessage());
            return Redirect::back();

        }

        Session::flash('message', 'Užduotis sukurta.');

        return Redirect::back();
    }
}
