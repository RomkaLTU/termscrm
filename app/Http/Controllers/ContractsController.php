<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Invoice;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class ContractsController extends Controller
{
    public function index()
    {
        return view('contracts.index', [

        ]);
    }

    public function json( Request $request )
    {
        $query = DB::table('contracts');
        $recordsTotal = $query->count();
        $recordsFiltered = $recordsTotal;
        $start = $request->input( 'start' );
        $length = $request->input( 'length' );

        $data = $query->skip ( $start )->take ( $length )->orderBy('updated_at','desc')->get();
        $col_data = [];

        foreach ($data as $col) {
            $col_data[] = [
                'DT_RowData' => [
                    'contractid' => $col->id,
                ],
                $col->contract_nr,
                $col->contract_status,
                $col->validity_value,
                $col->validity_extend_till_value,
                str_replace('.00','',money_format('%i', $col->contract_value)),
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
        return view('contracts.create', [

        ]);
    }

    public function store( Request $request )
    {
        try {
            $contract = Contract::create( $request->except('_token','contract_status','validity_extend_till','documents') );
            $this->attachMedia($contract, $request);
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::back();
        }

        Session::flash('message', 'Sutartis ' . $request->contract_nr . ' sukurta.');
        return Redirect::route('contracts.edit', $contract->id);
    }

    public function edit( Contract $contract )
    {
        $files = $contract->media;
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

        return view('contracts.edit', [
            'contract' => $contract,
            'documents' => $documents,
        ]);
    }

    public function update( Contract $contract, Request $request )
    {

        try {
            $contract->update( $request->except('_token','validity_extend_till','documents') );
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::back();
        }

        $this->attachMedia($contract, $request);

        Session::flash('message', 'Sutartis atnaujinta!');

        return Redirect::back();
    }

    public function destroy( Contract $contract )
    {

        $contract->delete();

        Session::flash('message', 'Sutartis ' . $contract->contract_nr . ' ištrinta!');
        return Redirect::back();
    }

    private function attachMedia($model, $request)
    {
        foreach ($request->input('documents', []) as $file) {
            $tmp_file = storage_path('tmp/uploads/' . $file);
            if ( file_exists($tmp_file) ) {
                $model->addMedia($tmp_file)->toMediaCollection('document');
            }
        }
    }
}
