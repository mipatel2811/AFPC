<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Models\ComponentVisibility;
use App\Models\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class ComponentVisibilitesDatatablesController extends Controller
{


    /**
     * Process ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getData(Request $request)
    {
        return Datatables::make($this->getForDataTable($request->all()))
            ->escapeColumns(['id'])
            ->editColumn('component_categories', function ($visibility) {
                if (!empty($visibility->category_title)) {
                    return  $visibility->category_title;
                } else {
                    return 'N/A';
                }
            })
            ->editColumn('description', function ($category) {

                //return "substr($category->description, 0, 100) . '...'";

                return  "$category->description";
                


            })
            ->editColumn('created_at', function ($visibility) {
                return Carbon::parse($visibility->created_at)->format('F d, Y');
            })->addColumn('conditions', function ($visibility) {
                $conditions ='<b>if</b> ';

                if (!empty($visibility->conditions)) {
                    
                    $conditions .= $visibility->category_title.' <b>is equeal to</b> ';
                    foreach (json_decode($visibility->conditions,true) as $key => $value) {
	                if($key==0){
	                   	$conditions .= ' ';
	                }else{
	                    $conditions .= '<b>Or</b> ';
	                }
	                    foreach ($value as $innerKey => $innerValue) {
	                    	$component=Component::find($innerValue);
	                    	if($innerKey==0){
	                    		$conditions .= $component->title.' ';
	                    	}else{
	                    		$conditions .= '<b>AND</b> '.$component->title.' ';
	                    	}
	                    }
                    }
                    return  $conditions;

                } else {
                    return 'N/A';
                }

            })
            ->addColumn('actions', function ($visibility) {
                return "<a href='" . route('component-visibilites.edit', $visibility->id) . "' class='btn btn-tool'><i class='fas fa-pen'></i></a>
                <a  href='javascript:;' class='btn btn-tool delete_" . $visibility->id . "' data-url='" . route('component-visibilites.destroy', $visibility->id) . "'  onclick='deleteRecorded(" . $visibility->id . ")'><i class='fas fa-trash'></i></a>";
            })
            ->make(true);
    }
    public function getForDataTable($input)
    {
        $dataTableQuery = ComponentVisibility::Leftjoin('components as cc', 'component_visibilities.component_id', '=', 'cc.id')->select('component_visibilities.*', 'cc.title as category_title');

        
        if (isset($input['date']) && $input['date'] != '') {
            $from = explode(' - ', $input['date'])[0];
            $to = explode(' - ', $input['date'])[1];
            $from = date('Y-m-d',strtotime($from));
            $to = date('Y-m-d',strtotime($to));
            $dataTableQuery->whereBetween('component_visibilities.created_at', [$from, $to]);
        }

        // if (isset($input['date']) && $input['date'] != '') {
        //     $dataTableQuery->whereDate('component_visibilities.created_at', '=', $input['date']);
        // }

        return  $dataTableQuery;
    }

}
