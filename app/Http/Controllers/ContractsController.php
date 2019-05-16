<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Invoice;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class ContractsController extends Controller
{
    private $columns = [
        'contract_nr',
        'contract_status',
        'validity_value',
        'validity_extend_till_value',
        'contract_value',
        'created_at',
        'updated_at',
    ];

    public function index()
    {
        return view('contracts.index', [

        ]);
    }

    public function json( Request $request )
    {
        $query = Contract::query();
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

        /*
         * Contract by date filter
         */
        if ( $request->contractsFrom ) {
            $query->whereDate('validity_value', '>=', $request->contractsFrom);
        }

        if ( $request->contractsTo ) {
            $query->whereDate('validity_value', '<=', $request->contractsTo);
        }

        $query->orWhere(function($q) use ($request){
            if ( $request->contractsFrom ) {
                $q->where('validity_extended', 1)
                    ->whereDate('validity_extend_till_value','>=', $request->contractsFrom);
            }

            if ( $request->contractsTo ) {
                $q->where('validity_extended', 1)
                    ->whereDate('validity_extend_till_value','<=', $request->contractsTo);
            }
        });

        /**
         * Check if there is any unpaid invoices by given date range
         */
        if ( $request->contractsUnpaidFrom ) {
            $query->whereHas('invoices', function($q) use ($request) {
                $q->whereDate('due_date', '>=', $request->contractsUnpaidFrom);
            });
        }

        if ( $request->contractsUnpaidTo ) {
            $query->whereHas('invoices', function($q) use ($request) {
                $q->whereDate('due_date', '<=', $request->contractsUnpaidTo);
            });
        }

        $recordsTotal = $query->count();
        $recordsFiltered = $recordsTotal;

        $data = $query->skip ( $start )->take ( $length )
            ->orderBy('late','desc')
            ->orderBy('updated_at','desc')
            ->get();

        $col_data = [];

        foreach ($data as $col) {
            $col_data[] = [
                'DT_RowData' => [
                    'rowid' => $col->id,
                    'late' => $col->late,
                ],
                $col->contract_nr,
                ucfirst($col->contract_status),
                $col->validity_value,
                $col->validity_extend_till_value,
                str_replace('.00','',money_format('%i', $col->contract_value)),
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
            'research_areas' => $contract->objs->pluck('researchAreas')->flatten()->unique('id'),
        ]);
    }

    public function update( Contract $contract, Request $request )
    {
        try {
            $contract->update( $request->except('_token','documents') );
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
