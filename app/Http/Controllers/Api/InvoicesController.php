<?php

namespace App\Http\Controllers\Api;

use App\Contract;
use App\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoicesController extends Controller
{
    public function index( Contract $contract, Request $request )
    {
        $invoices = $contract->find($request->contract_id)->invoices();

        return $invoices->get();
    }

    public function store( Request $request )
    {
        try {
            $invoice = Invoice::create( $request->all() );
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $invoice;
    }

    public function destroy( $invoice_id )
    {
        $invoice_to_delete = Invoice::find($invoice_id);
        $invoice_to_delete->delete();

        return $invoice_to_delete;
    }
}
