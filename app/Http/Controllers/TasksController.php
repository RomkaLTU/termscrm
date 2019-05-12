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
    private $columns = [
        'id',
        'name',
        'due_date',
        'notes_1',
        'notes_2',
        'created_at',
        'updated_at',
    ];

    public function index( Contract $contract, Obj $object )
    {
        return view('tasks.index', [
            'contract' => $contract,
            'obj' => $object,
            'tasks' => ObjTask::where('contract_id', $contract->id)->where('object_id', $object->id)->get(),
            'research_areas' => ResearchArea::all(),
        ]);
    }

    public function json( Request $request, Contract $contract, Obj $object )
    {
        $query = ObjTask::where('contract_id', $contract->id)->where('object_id', $object->id);

        if ( empty($request->all()) ) {
            return $query->get();
        }

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

        if ( !empty($request->researchArea) ) {
            $query->where('research_area_id',$request->researchArea);
        }

        /*
         * Tasks by date filter
         */
        if ( $request->tasksFrom ) {
            $query->whereDate('due_date', '>=', $request->tasksFrom);
        }

        if ( $request->tasksTo ) {
            $query->whereDate('due_date', '<=', $request->tasksTo);
        }

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
                $col->due_date,
                $col->taskParams->pluck('name')->implode(', '),
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
            'task_params_selected' => $task->taskParams->pluck('id'),
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

        $task->taskParams()->sync( $this->task_params($request) );

        $tasks_list_url = route('contracts.objects.tasks.index', [$request->contract_id, $request->object_id]);

        Session::flash('message', 'Užduotis sukurta.');
        Session::flash('message', "Užduotis {$task->name} sukurta. <a class='text-white' href='{$tasks_list_url}'><u>Grįžti į sąrašą</u></a>.");

        return Redirect::back();
    }

    public function update( Request $request, Contract $contract, Obj $object, ObjTask $task )
    {
        try {

            $task->update($request->except('_method','_token','task_params'));

        } catch (\Exception $e) {

            Session::flash('error', $e->getMessage());
            return Redirect::back();

        }

        $task->taskParams()->sync( $this->task_params($request) );

        Session::flash('message', 'Užduotis atnaujinta');

        return Redirect::back();
    }

    public function destroy( Contract $contract, Obj $object, ObjTask $task )
    {
        $task->delete();

        Session::flash('message', 'Užduotis ' . $task->name . ' ištrinta!');
        return Redirect::back();
    }

    /**
     * Check if all values is integers
     * If not, new tag was just created, get that tag ID
     * @param $request
     * @return array
     */
    private function task_params( $request )
    {
        $task_params = [];
        foreach ($request->task_params as $task_param) {
            if ( is_numeric($task_param) ) {
                $task_params[] = $task_param;
            } else {
                $found_task_param = TaskParam::whereName($task_param)->first();
                if ( $found_task_param ) {
                    $task_params[] = $found_task_param->id;
                }
            }
        }

        return $task_params;
    }
}
