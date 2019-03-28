<?php

namespace App\Http\Controllers\Api;

use App\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoicesController extends Controller
{
    public function store( Request $request )
    {
        try {
            $invoice = Invoice::create( $request->all() );
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $invoice;
    }
}
