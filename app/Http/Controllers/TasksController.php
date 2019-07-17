<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Obj;
use App\ObjTask;
use App\ParamGroup;
use App\ResearchArea;
use App\TaskParam;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

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
        $supervisors = [];
        foreach ( $object->researchAreas->pluck('pivot')->pluck('user_id','research_area_id') as $ra_id => $user_id ) {
            if ( $user_id ) {
                $supervisors[$ra_id] = User::find($user_id);
            }
        }

        return view('tasks.index', [
            'contract' => $contract,
            'obj' => $object,
            'tasks' => ObjTask::where('contract_id', $contract->id)->where('object_id', $object->id)->get(),
            'research_areas' => ResearchArea::all(),
            'supervisors' => $supervisors,
        ]);
    }

    public function json( Request $request, Contract $contract, Obj $object )
    {
        $query = ObjTask::where('contract_id', $contract->id)->where('object_id', $object->id);
        $query_ecog = ObjTask::where('contract_id', $contract->id)->where('object_id', $object->id);

        if ( $request->researchArea == 4 ) {
            $query->where('ecog','0')->where('research_area_id', '4');
        }

        if ( $request->ecog ) {
            $query_ecog = $query_ecog->where('ecog','1');
        }

        if ( empty($request->all()) ) {
            return $query->get();
        }

        $recordsTotal = $query->count();
        $recordsTotalEcog = $query_ecog->count();
        $recordsFiltered = $recordsTotal;
        $recordsFilteredEcog = $recordsTotalEcog;
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
        $col_data_ecog = [];

        foreach ($data as $col) {

            $due_date = $col->due_date;
            $params = $col->taskParams->pluck('name')->toArray();
            $param_groups = $col->paramGroups->pluck('name')->toArray();


            if ( !empty($col->requiring_int) ) {
                $due_date = $col->requiring_int;
            }

            $col_data[] = [
                'DT_RowData' => [
                    'taskid' => $col->id,
                    'objectid' => $object->id,
                    'contractid' => $contract->id,
                    'special' => $col->special_task,
                    'researcharea' => Str::slug($col->researchArea->name),
                ],
                $col->id,
                $col->name,
                $due_date,
                implode(', ', array_merge($params)),
                $col->notes_1,
                $col->notes_2,
            ];
        }

        /**
         * 2 lenteles tame paciame viewse
         */
        if ( $request->ecog ) {
            $data_ecog = $query_ecog->skip ( $start )->take ( $length )->orderBy('updated_at','desc')->get();
            foreach ($data_ecog as $col) {
                $col_data_ecog[] = [
                    'DT_RowData' => [
                        'taskid' => $col->id,
                        'objectid' => $object->id,
                        'contractid' => $contract->id,
                        'special' => $col->special_task,
                    ],
                    $col->id,
                    $col->name,
                    $col->due_date,
                    $col->taskParams->pluck('name')->implode(', '),
                    $col->notes_1,
                    $col->notes_2,
                ];
            }

            return [
                'draw' => intval( $request->input( 'draw' ) ),
                'recordsTotal' => $recordsTotalEcog,
                'recordsFiltered' => $recordsFilteredEcog,
                "data" => $col_data_ecog,
            ];
        }

        return [
            'draw' => intval( $request->input( 'draw' ) ),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            "data" => $col_data,
        ];
    }

    public function create( Contract $contract, Obj $object )
    {
        return view('tasks.create', [
            'contract' => $contract,
            'obj' => $object,
            'research_areas' => ResearchArea::all(),
            'task_params' => TaskParam::all(),
            'task_params_groups' => ParamGroup::all(),
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
            'task_params_groups' => ParamGroup::all(),
            'research_area' => $task->research_area_id,
            'research_areas' => ResearchArea::all(),
            'task_params_selected' => $task->taskParams->pluck('id'),
            'task_params_groups_selected' => $task->paramGroups->pluck('id'),
            'task_params' => TaskParam::all(),
        ]);
    }

    public function store( Request $request )
    {
        $task = ObjTask::create( $request->except('_token', 'research_area','task_params','task_params_groups') );
        $this->setRequiringDate($request, $task);

        $task->taskParams()->sync( $this->task_params($request) );
        $task->paramGroups()->sync( $request->task_params_groups );

        $tasks_list_url = route('contracts.objects.tasks.index', [$request->contract_id, $request->object_id]);

        Session::flash('message', 'Užduotis sukurta.');
        Session::flash('message', "Užduotis {$task->name} sukurta. <a class='text-white' href='{$tasks_list_url}'><u>Grįžti į sąrašą</u></a>.");

        return Redirect::back();
    }

    public function update( Request $request, Contract $contract, Obj $object, ObjTask $task )
    {
        $task->update( $request->except('_method','_token','task_params','task_params_groups','requiring_int') );

        $this->setRequiringDate($request, $task);

        $task->taskParams()->sync( $this->task_params($request) );
        $task->paramGroups()->sync( $request->task_params_groups );

        Artisan::call('check:tasks');

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

        if ( $request->task_params ) {
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
        }

        return $task_params;
    }

    public function generatePdf( Request $request )
    {
        $taskids = explode(',', $request->tasks);
        $tasks = ObjTask::whereIn('id', $taskids)->where('special_task', 0)->get();
        $header = View::make('pdf.header')->render();
        $pdf_html = [];

        $tasks_full = $tasks->filter(function($value){
            return !in_array( Str::camel( $value->researchArea->name ), ['rasto_darbai','orai','kita'] );
        });

        $tasks_simple = $tasks->filter(function($value){
            return in_array( Str::camel( $value->researchArea->name ), ['orai','kita'] );
        });

        $tasks_parameterless = $tasks->filter(function($value){
            return in_array( Str::camel( $value->researchArea->name ), ['rasto_darbai'] );
        });

        $doc_html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Terminų valdymo sistema - UAB Ekometrija</title>
            <link href="'. env('APP_URL') .'/css/tailwind.css" rel="stylesheet" type="text/css">
            <style>
                body {
                    font-family: DejaVu Sans, sans-serif;
                    font-size: 14px;
                }
                .user-input {
                    border: none;
                    border-bottom: 1px solid #333;
                }
                .page-break {
                    page-break-after: always;
                }
            </style>
        </head>
        <body class="">
        <div style="width:800px;margin:0 auto;">
        ';

        foreach ( $tasks_simple->pluck('obj')->unique() as $object ) {
            $tasks = ObjTask::whereIn('id', $taskids)->where('object_id', $object->id)->where('special_task', 0)->get();

            $tasks_simple = $tasks->filter(function($value){
                return in_array( Str::camel( $value->researchArea->name ), ['orai','kita'] );
            });

            foreach ( $tasks_simple->groupBy('researchArea.id') as $tasks_distinct ) {
                $pdf = PDF::loadView('pdf.tasks-simple', [
                    'tasks' => $tasks_distinct,
                ]);

                $pdf_html[] = $pdf->html;
            }
        }

        foreach ( $tasks_parameterless->groupBy('researchArea.id') as $tasks_distinct ) {
            $pdf = PDF::loadView('pdf.tasks-parameterless', [
                'tasks' => $tasks_distinct,
            ]);

            $pdf_html[] = $pdf->html;
        }

        foreach( $tasks_full->pluck('obj')->unique() as $object ) {
            $tasks = ObjTask::whereIn('id', $taskids)->where('object_id', $object->id)->where('special_task', 0)->get();

            $tasks_full = $tasks->filter(function($value){
                return !in_array( Str::camel( $value->researchArea->name ), ['rasto_darbai','orai','kita'] );
            });

            foreach ( $tasks_full->groupBy('researchArea.id') as $tasks_distinct ) {

                $task = $tasks_distinct->first();
                $obj = $task->obj;

                $details_arr = [
                    $obj->name,
                    $obj->details,
                ];

                $supervisor = DB::table('obj_research_area')
                    ->leftJoin('users', 'users.id', '=', 'obj_research_area.user_id')
                    ->select('users.*')
                    ->where('obj_id', $task->object_id)
                    ->where('research_area_id', $task->research_area_id)->first();

                if ( $supervisor ) {
                    array_push($details_arr, $supervisor->name);
                    array_push($details_arr, $supervisor->phone);
                }

                if ( !empty($obj->notes_1) ) {
                    array_push( $details_arr, $obj->notes_1 );
                }

                $details = implode(', ', array_filter($details_arr));

                $pdf = PDF::loadView('pdf.tasks', [
                    'tasks' => $tasks_distinct,
                    'details' => $details,
                ]);

                $pdf_html[] = $pdf->html;
            }
        }

        foreach ( $pdf_html as $doc ) {
            $doc_html .= $doc;
            $doc_html .= '<div class="page-break"></div>';
        }

        $doc_html .= '
        </div>
        </body>
        </html>
        ';

        if ( empty($pdf_html) ) {
            return Redirect::back();
        }

        return PDF::loadHTML($doc_html)->setPaper('a4')->setOption('header-html', $header)->download('ekometrija_darbai.pdf');
    }

    /**
     * @param $request
     * @param $task
     */
    private function setRequiringDate($request,$task)
    {
        $current_day_of_month = Carbon::now()->format('d');
        $current_month_middle = Carbon::now()->startOfMonth()->addDay(intval(Carbon::now()->daysInMonth / 2))->format('Y-m-d');
        $current_month_last_day = Carbon::now()->endOfMonth()->format('Y-m-d');
        $current_last_of_quarter = Carbon::now()->lastOfQuarter()->format('Y-m-d');
        $middle_of_current_year = Carbon::now()->year . '-06-15';

        if ( $request->requiring_int ) {
            switch ($request->requiring_int)
            {
                case '2k. / mėn.':
                    if ( $current_day_of_month <= $current_month_middle ) {
                        $due_date = $current_month_middle;
                    } else {
                        $due_date = $current_month_last_day;
                    }

                    $task->update([
                        'due_date' => $due_date,
                    ]);

                    break;

                case '1k. / mėn.':
                    $task->update([
                        'due_date' => $current_month_last_day,
                    ]);
                    break;

                case '1k. / ketv.':
                    $task->update([
                        'due_date' => $current_last_of_quarter,
                    ]);
                    break;

                case '2k. / met.':
                    if ( Carbon::now()->format('Y-m-d') < $middle_of_current_year ) {
                        $due_date = $middle_of_current_year;
                    } else {
                        $due_date = Carbon::now()->endOfYear()->format('Y-m-d');
                    }

                    $task->update([
                        'due_date' => $due_date,
                    ]);
                    break;

                case '1k. / met.':
                    $task->update([
                        'due_date' => Carbon::now()->endOfYear()->format('Y-m-d'),
                    ]);
                    break;
            }

            $task->update([
                'requiring_int' => $request->requiring_int,
            ]);
        } else {
            $task->update([
                'requiring_int' => null,
            ]);
        }
    }
}
