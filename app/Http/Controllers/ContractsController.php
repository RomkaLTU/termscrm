<?php

namespace App\Http\Controllers;

use App\Contract;
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
            $contract = Contract::create( $request->except('_token','contract_status','research_area','address','customer','validity_extend_till') );
            $contract->researchAreas()->attach($request->research_area);
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::back();
        }

        Session::flash('message', 'Sutartis ' . $request->contract_nr . ' sukurta.');
        return Redirect::to('contracts');
    }

    public function edit( User $user )
    {
        return view('users.edit', [
            'user' => $user,
            'roles' => Role::all(),
        ]);
    }

    public function update( User $user, Request $request )
    {
        try {
            $user->update( array_filter( $request->except('role') ) );
        } catch (\Exception $e) {
            Session::flash('error', 'Vartotojas su tokiu el. pašto adresu jau yra!');
            return Redirect::back();
        }

        $user->syncRoles( $request->role );

        Session::flash('message', 'Vartotojas atnaujintas!');

        return Redirect::to('users');
    }

    public function destroy( User $user )
    {
        if ( $user->id == auth()->user()->id ) {
            Session::flash('error', 'Savo paskyros trynimas negalimas');
            return Redirect::back();
        }

        $user->delete();

        Session::flash('message', 'Vartotojas ' . $user->name . ' ištrintas!');
        return Redirect::back();
    }
}
