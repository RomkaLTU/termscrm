<?php

namespace App\Http\Controllers\Api;

use App\Contract;
use App\Obj;
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

    public function get_visits( $contract_id, $object_id )
    {
        $obj_visits = ObjVisit::where('contract_id', $contract_id)->where('object_id', $object_id)->get();

        return $obj_visits;
    }
}
