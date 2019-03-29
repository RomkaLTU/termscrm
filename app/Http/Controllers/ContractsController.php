<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Invoice;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class ContractsController extends Controller
{
    public function index()
    {
        $contracts = Contract::paginate('10');

        return view('contracts.index', [
            'contracts' => $contracts
        ]);
    }

    public function create()
    {
        return view('contracts.create', [

        ]);
    }

    public function store( Request $request )
    {
        try {
            $contract = Contract::create( $request->except('_token','contract_status','research_area','validity_extend_till') );
            $contract->researchAreas()->attach($request->research_area);
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::back();
        }

        Session::flash('message', 'Sutartis ' . $request->contract_nr . ' sukurta.');
        return Redirect::route('contracts.edit', $contract->id);
    }

    public function edit( Contract $contract )
    {
        return view('contracts.edit', [
            'contract' => $contract,
            'research_areas' => $contract->researchAreas->pluck('id'),
        ]);
    }

    public function update( Contract $contract, Request $request )
    {
        try {
            $contract->update( array_filter($request->except('_token','contract_status','research_area','validity_extend_till')) );
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::back();
        }

        $contract->researchAreas()->sync($request->research_area);

        Session::flash('message', 'Sutartis atnaujinta!');

        return Redirect::back();
    }

    public function destroy( Contract $contract )
    {

        $contract->delete();

        Session::flash('message', 'Sutartis ' . $contract->contract_nr . ' ištrinta!');
        return Redirect::back();
    }
}
