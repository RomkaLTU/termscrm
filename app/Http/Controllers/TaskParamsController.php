<?php

namespace App\Http\Controllers;

use App\ResearchArea;
use App\TaskParam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TaskParamsController extends Controller
{
    public function index()
    {
        return view('taskparams.index', [

        ]);
    }

    public function edit( TaskParam $taskparam )
    {
        return view('taskparams.edit', [
            'task_param' => $taskparam,
            'research_area' => $taskparam->researchAreas->pluck('pivot')->pluck('research_area_id'),
            'research_areas' => ResearchArea::all(),
        ]);
    }

    public function update( TaskParam $taskparam, Request $request )
    {
        try {

            $taskparam->update( $request->except('_token','research_area') );

            $taskparam->researchAreas()->sync($request->research_area);

        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::back();
        }

        Session::flash('message', 'Parametras atnaujintas!');

        return Redirect::back();
    }

    public function create()
    {
        return view('taskparams.create', [
            'research_areas' => ResearchArea::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $taskparam = TaskParam::create( $request->except('_token', 'research_area') );
        $taskparam->researchAreas()->attach($request->research_area);

        Session::flash('message', 'Parametras sukurtas!');

        return Redirect::back();
    }

    public function json( Request $request )
    {
        $query = TaskParam::query();
        $start = $request->input( 'start' );
        $length = $request->input( 'length' );

        $recordsTotal = $query->count();
        $recordsFiltered = $recordsTotal;

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

        $data = $query->skip($start)->take($length)->get();

        $col_data = [];

        foreach ($data as $col) {
            $col_data[] = [
                'DT_RowData' => [
                    'rowid' => $col->id,
                ],
                $col->id,
                $col->name,
                $col->researchAreas->pluck('name'),
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

    public function destroy( TaskParam $taskparam )
    {

        $taskparam->delete();

        Session::flash('message', 'Parametras ištrintas!');
        return Redirect::back();
    }
}
