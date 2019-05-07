<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    private $columns = [
        'id',
        'name',
        'email',
        'duties',
        'created_at',
        'updated_at',
    ];

    public function index()
    {
        $users = User::all();

        return view('users.index', [
            'users' => $users
        ]);
    }

    public function json( Request $request )
    {
        $query = DB::table('users');
        $recordsTotal = $query->count();
        $recordsFiltered = $recordsTotal;
        $start = $request->input( 'start' );
        $length = $request->input( 'length' );

        /*
         * Order By
         */
        if ($request->has ( 'order' )) {
            if ($request->input ( 'order.0.column' ) != '') {
                $orderColumn = $request->input ( 'order.0.column' );
                $orderDirection = $request->input ( 'order.0.dir' );
                $query->orderBy ( $this->columns[intval($orderColumn)], $orderDirection );
            }
        }

        $data = $query->skip ( $start )->take ( $length )->orderBy('updated_at','desc')->get();
        $col_data = [];

        foreach ($data as $col) {
            $col_data[] = [
                'DT_RowData' => [
                    'rowid' => $col->id,
                ],
                $col->id,
                $col->name,
                $col->email,
                $col->duties,
                $col->created_at,
                $col->updated_at,
            ];
        }

        $response = [
            'draw' => intval( $request->input( 'draw' ) ),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            "data" => $col_data,
        ];

        return $response;
    }

    public function create()
    {
        return view('users.create', [
            'roles' => Role::all(),
        ]);
    }

    public function store( Request $request )
    {
        try {
            $user = User::create( $request->except('role') );
            $user->syncRoles( $request->role );
        } catch (\Exception $e) {
            Session::flash('error', 'Vartotojas su tokiu el. pašto adresu jau yra!');
            return Redirect::back();
        }

        Session::flash('message', 'Vartotojas ' . $request->name . ' sukurtas.');
        return Redirect::to('users');
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
