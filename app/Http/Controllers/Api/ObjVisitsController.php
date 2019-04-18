<?php

namespace App\Http\Controllers\Api;

use App\ObjVisit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ObjVisitsController extends Controller
{
    public function visits( Request $request )
    {
        foreach ( $request->checked as $checked ) {
            ObjVisit::create([
                'contract_id' => $checked['contract_id'],
                'object_id' => $checked['value'],
                'user_id' => $request->user_id,
            ]);
        }
    }
}
