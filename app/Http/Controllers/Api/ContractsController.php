<?php

namespace App\Http\Controllers\Api;

use App\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContractsController extends Controller
{
    public function search( Request $request )
    {
        $results = Contract::where('contract_nr', 'like', '%' . $request->search . '%')
            ->take(10)
            ->orderBy('updated_at','desc')
            ->get();

        return $results;
    }
}
