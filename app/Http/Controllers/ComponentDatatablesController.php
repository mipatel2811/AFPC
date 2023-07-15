<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class ComponentDatatablesController extends Controller
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
            ->editColumn('image', function ($component) {
                if ($component->image != '') {
                    return "<img src='" . URL::to('/') . "/public/img/components/" . $component->image . "' height='100' width='100'/>";
                } else {
                    return "N/A";
                }
            })
            ->editColumn('description', function ($component) {
                return substr($component->description, 0, 100) . '...';
            })
            ->editColumn('category_title', function ($component) {
                if (!empty($component->category_title)) {
                    return  $component->category_title;
                } else {
                    return 'N/A';
                }
            })
            ->editColumn('brand_title', function ($component) {
                if (!empty($component->brand_title)) {
                    return  $component->brand_title;
                } else {
                    return 'N/A';
                }
            })
            ->editColumn('is_active', function ($component) {
                if ($component->is_active == 1) {
                    return "<label class='badge bg-success'>Yes</label>";
                } else {
                    return "<label class='badge bg-warning'>No</label>";
                }
            })
            ->editColumn('created_at', function ($component) {
                return Carbon::parse($component->created_at)->format('F d, Y');
            })->addColumn('actions', function ($component) {
                return "<a href='" . route('components.edit', $component->id) . "' class='btn btn-tool'><i class='fas fa-pen'></i></a>
                <a href='javascript:;' class='btn btn-tool delete_" . $component->id . "' data-url='" . route('components.destroy', $component->id) . "'  onclick='deleteRecorded(" . $component->id . ")'><i class='fas fa-trash'></i></a>";
            })
            ->make(true);
    }

    public function getForDataTable($input)
    {

        $dataTableQuery = Component::Leftjoin('component_categories as cc', 'components.category_id', '=', 'cc.id')->Leftjoin('component_brands as cb','components.brand_id','=','cb.id')->select('components.*', 'cc.title as category_title','cb.title as brand_title');

        if (isset($input['date']) && $input['date'] != '') {
            $from = explode(' - ', $input['date'])[0];
            $to = explode(' - ', $input['date'])[1];
            $from = date('Y-m-d',strtotime($from));
            $to = date('Y-m-d',strtotime($to));
            $dataTableQuery->whereBetween('components.created_at', [$from, $to]);
        }

        // if (isset($input['date']) && $input['date'] != '') {
        //     $dataTableQuery->whereDate('components.created_at', '=', $input['date']);
        // }


        if (isset($input['cat_id']) && $input['cat_id'] != '') {
            $dataTableQuery->where('cc.id', '=', $input['cat_id']);
        }


        return  $dataTableQuery;
    }
}
