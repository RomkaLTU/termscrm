<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Obj;
use App\ResearchArea;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ObjsController extends Controller
{
    private $columns = [
        'id',
        'name',
        'details',
        'notes_1',
        'notes_2',
        'created_at',
        'updated_at',
    ];

    public function index( Contract $contract )
    {
        return view('objects.index', [
            'contract' => $contract,
        ]);
    }

    public function json( Request $request, Contract $contract )
    {
        $query = Obj::whereHas('contract', function($q) use ($contract){
            $q->where('id', $contract->id);
        });

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
                    'objectid' => $col->id,
                    'contractid' => $contract->id,
                ],
                $col->id,
                $col->name,
                $col->details,
                $col->notes_1,
                $col->notes_2,
                '',
                '',
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

    public function create( Contract $contract )
    {
        return view('objects.create', [
            'contract' => $contract,
            'users' => User::all(),
            'research_areas' => ResearchArea::all(),
        ]);
    }

    public function store( Request $request, Contract $contract )
    {
        $obj = Obj::create( $request->except('_token', 'research_area', 'ra_supervisor') );

        $contract->objs()->attach( $obj->id );

        $ra_users_arr = [];
        foreach ($request->research_area as $ra) {
            $ra_users_arr[$ra] = ['user_id' => $request->ra_supervisor[$ra]];
        }

        $obj->researchAreas()->attach($ra_users_arr);

        $this->attachMedia($obj, $request);

        $objects_list_url = route('contracts.objects.index', $contract->id);

        Session::flash('message', "Objektas {$obj->name} sukurtas. <a class='text-white' href='{$objects_list_url}'><u>Grįžti į sąrašą</u></a>.");

        return Redirect::route('contracts.objects.edit', [ $contract->id, $obj->id ]);
    }

    public function edit( Contract $contract, Obj $object )
    {
        $files = $object->media;
        $documents = [];

        foreach($files as $file) {
            $documents[] = [
                'id' => $file->id,
                'name' => $file->file_name,
                'url' => $file->getFullUrl(),
                'size' => $file->size,
                'type' => $file->mime_type,
            ];
        }

        $ras = $object->researchAreas->pluck('pivot');

        $supervisors = [];
        foreach ($ras as $ra) {
            $supervisors[$ra->research_area_id] = $ra->user_id;
        }

        return view('objects.edit', [
            'contract' => $contract,
            'obj' => $object,
            'users' => User::all(),
            'supervisors' => $supervisors,
            'documents' => $documents,
            'research_area' => $ras->pluck('research_area_id'),
            'research_areas' => ResearchArea::all(),
        ]);
    }

    public function update( Request $request, Contract $contract, Obj $object )
    {
        try {
            $object->update($request->except('_method','_token','research_area'));
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        $ra_users_arr = [];
        foreach ($request->research_area as $ra) {
            $ra_users_arr[$ra] = ['user_id' => $request->ra_supervisor[$ra]];
        }

        $object->researchAreas()->sync($ra_users_arr);

        $this->attachMedia($object, $request);

        Session::flash('message', 'Objektas atnaujintas!');

        return Redirect::back();
    }

    public function destroy( Contract $contract, Obj $object )
    {

        $object->delete();

        Session::flash('message', 'Sutarties ' . $contract->contract_nr . ' objektas ' . $object->name . ' ištrintas!');
        return Redirect::back();
    }

    private function attachMedia($model, $request)
    {
        foreach ($request->input('documents', []) as $file) {
            $tmp_file = storage_path('tmp/uploads/' . $file);
            if ( file_exists($tmp_file) ) {
                $model->addMedia($tmp_file)->toMediaCollection('obj');
            }
        }
    }
}
