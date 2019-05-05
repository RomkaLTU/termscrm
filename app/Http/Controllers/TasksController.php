<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Obj;
use App\ObjTask;
use App\ResearchArea;
use App\TaskParam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TasksController extends Controller
{
    public function index( Contract $contract, Obj $object )
    {
        return view('tasks.index', [
            'contract' => $contract,
            'obj' => $object,
            'tasks' => ObjTask::where('contract_id', $contract->id)->where('object_id', $object->id)->get(),
        ]);
    }

    public function json( Request $request, Contract $contract, Obj $object )
    {
        $query = ObjTask::where('contract_id', $contract->id)->where('object_id', $object->id);

        $recordsTotal = $query->count();
        $recordsFiltered = $recordsTotal;
        $start = $request->input( 'start' );
        $length = $request->input( 'length' );

        $data = $query->skip ( $start )->take ( $length )->orderBy('updated_at','desc')->get();
        $col_data = [];

        foreach ($data as $col) {
            $col_data[] = [
                'DT_RowData' => [
                    'taskid' => $col->id,
                    'objectid' => $object->id,
                    'contractid' => $contract->id,
                ],
                $col->id,
                $col->name,
                '',
                '',
                $col->notes_1,
                $col->notes_2,
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

    public function create( Contract $contract, Obj $object )
    {
        return view('tasks.create', [
            'contract' => $contract,
            'obj' => $object,
            'research_areas' => ResearchArea::all(),
            'task_params' => TaskParam::all(),
        ]);
    }

    public function store( Request $request )
    {
        try {

            $task = ObjTask::create( $request->except('_token', 'research_area','task_params') );

        } catch (\Exception $e) {

            Session::flash('error', $e->getMessage());
            return Redirect::back();

        }

        Session::flash('message', 'Užduotis sukurta.');

        return Redirect::back();
    }

    public function edit( Contract $contract, Obj $object, ObjTask $task )
    {
        $documents = [];

        return view('tasks.edit', [
            'contract' => $contract,
            'obj' => $object,
            'documents' => $documents,
            'task' => $task,
            'research_area' => $task->research_area_id,
            'research_areas' => ResearchArea::all(),
            'task_params' => TaskParam::all(),
        ]);
    }

    public function update( Request $request, Contract $contract, Obj $object, ObjTask $task )
    {
        try {

            $task->update($request->except('_method','_token'));

        } catch (\Exception $e) {

            Session::flash('error', $e->getMessage());
            return Redirect::back();

        }

        Session::flash('message', 'Užduotis atnaujinta');

        return Redirect::back();
    }

    public function destroy( Contract $contract, Obj $object, ObjTask $task )
    {
        $task->delete();

        Session::flash('message', 'Užduotis ' . $task->name . ' ištrinta!');
        return Redirect::back();
    }
}
