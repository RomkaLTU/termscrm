<?php

namespace App\Http\Controllers\Api;

use App\Contract;
use App\Obj;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ObjsController extends Controller
{
    public function search( Request $request )
    {
        $results = Obj::where('name', 'like', '%' . $request->search . '%')
            ->orWhere('details','like', '%' . $request->search . '%')
            ->orWhere('notes_1','like', '%' . $request->search . '%')
            ->orWhere('notes_2','like', '%' . $request->search . '%')
            ->take(10)
            ->orderBy('updated_at','desc')
            ->get();

        return $results;
    }
}
