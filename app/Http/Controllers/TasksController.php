<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Obj;
use App\ResearchArea;
use Illuminate\Http\Request;

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

    public function store()
    {

    }
}
