<?php

namespace App\Http\Controllers;

use App\Contract;
use Illuminate\Http\Request;

class ObjectsController extends Controller
{
    public function index( Contract $contract )
    {
        return view('objects.index', [
            'contract' => $contract,
        ]);
    }

    public function create( Contract $contract )
    {
        return view('objects.create', [
            'contract' => $contract,
        ]);
    }

    public function store()
    {
        //
    }
}
