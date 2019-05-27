<?php

namespace App\Http\Controllers;

use App\ObjTask;
use App\Region;
use App\ResearchArea;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'research_areas' => ResearchArea::all(),
            'regions' => Region::all(),
        ]);
    }

    public function json( Request $request )
    {
        $query = ObjTask::whereHas('contract', function($q){
            $q->where('contract_status','galiojanti');
        });

        $query->doesntHave('visits');

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

        if ( !empty($request->region) ) {
            $query->whereHas('obj', function($q) use ($request){
                $q->where('region_id', $request->region);
            });
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

        $data = $query->skip ( $start )
            ->take ( $length )
            ->orderBy('late','desc')
            ->orderBy('updated_at','desc')
            ->get();

        $col_data = [];

        foreach ($data as $col) {

            $due_date = $col->due_date;

            if ( !empty($col->requiring_int) ) {
                $due_date = $col->requiring_int;
            }

            $col_data[] = [
                'DT_RowData' => [
                    'taskid' => $col->id,
                    'objectid' => $col->obj->id,
                    'contractid' => $col->contract->id,
                    'special' => $col->special_task,
                    'late' => $col->late,
                ],
                $col->obj->name,
                $col->obj->region['name'],
                $col->researchArea->name,
                $col->name,
                $due_date,
            ];
        }

        return [
            'draw' => intval( $request->input( 'draw' ) ),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            "data" => $col_data,
        ];
    }
}
