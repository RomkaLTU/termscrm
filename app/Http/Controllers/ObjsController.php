<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Obj;
use App\ResearchArea;
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
            'research_areas' => ResearchArea::all(),
        ]);
    }

    public function store( Request $request, Contract $contract )
    {
        try {

            $obj = Obj::create( $request->except('_token', 'research_area') );

            $obj->researchAreas()->attach( $request->research_area );
            $contract->objs()->attach( $obj->id );
            $this->attachMedia($obj, $request);

        } catch (\Exception $e) {
            echo $e->getMessage();
        }

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

        return view('objects.edit', [
            'contract' => $contract,
            'obj' => $object,
            'documents' => $documents,
            'research_area' => $object->researchAreas->pluck('id'),
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

        $object->researchAreas()->sync($request->research_area);

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
