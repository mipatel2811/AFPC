<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Models\ComponentCategories;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class ComponentCategoriesDatatablesController extends Controller
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
            ->editColumn('image', function ($category) {
                if ($category->image != '') {
                    return "<img src='" . URL::to('/') . "/public/img/component-categories/" . $category->image . "' height='100' width='100'/>";
                } else {
                    return "N/A";
                }
            })
            ->editColumn('description', function ($category) {
                return substr($category->description, 0, 100) . '...';
            })
            ->editColumn('is_active', function ($category) {
                if ($category->is_active == 1) {
                    return "<label class='badge bg-success'>Yes</label>";
                } else {
                    return "<label class='badge bg-warning'>No</label>";
                }
            })
            ->editColumn('created_at', function ($category) {
                return Carbon::parse($category->created_at)->format('F d, Y');
            })->addColumn('no_of_component', function ($category) {
                return count($category->getComponents);
            })->addColumn('actions', function ($category) {
                return "<a href='" . route('component-categories.edit', $category->id) . "' class='btn btn-tool'><i class='fas fa-pen'></i></a>
                <a  href='javascript:;' class='btn btn-tool delete_" . $category->id . "' data-url='" . route('component-categories.destroy', $category->id) . "'  onclick='deleteRecorded(" . $category->id . ")'><i class='fas fa-trash'></i></a>";
            })
            ->make(true);
    }
    public function getForDataTable($input)
    {

        $dataTableQuery = ComponentCategories::orderBy('id', 'desc');


    if (isset($input['date']) && $input['date'] != '') {
            $from = explode(' - ', $input['date'])[0];
            $to = explode(' - ', $input['date'])[1];
            $from = date('Y-m-d',strtotime($from));
            $to = date('Y-m-d',strtotime($to));
            $dataTableQuery->whereBetween('created_at', [$from, $to]);
        }

        // if (isset($input['date']) && $input['date'] != '') {
        //     $dataTableQuery->whereDate('created_at', '=', $input['date']);
        // }
       
        return  $dataTableQuery;
    }

}
