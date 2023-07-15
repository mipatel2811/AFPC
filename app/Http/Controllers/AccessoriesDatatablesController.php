<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Accessories;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class AccessoriesDatatablesController extends Controller
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
            ->editColumn('image', function ($accessories) {
                if ($accessories->image != '') {
                    return "<img src='" . URL::to('/') . "/public/img/accessories/" . $accessories->image . "' height='100' width='100'/>";
                } else {
                    return "N/A";
                }
            })
            ->editColumn('description', function ($accessories) {
                return substr($accessories->description, 0, 100) . '...';
            })
            ->editColumn('category_title', function ($accessories) {
                if (!empty($accessories->category_title)) {
                    return  $accessories->category_title;
                } else {
                    return 'N/A';
                }
            })
            ->editColumn('is_active', function ($accessories) {
                if ($accessories->is_active == 1) {
                    return "<label class='badge bg-success'>Yes</label>";
                } else {
                    return "<label class='badge bg-warning'>No</label>";
                }
            })
            ->editColumn('created_at', function ($accessories) {
                return Carbon::parse($accessories->created_at)->format('F d, Y');
            })->addColumn('actions', function ($accessories) {
                return "<a href='" . route('accessories.edit', $accessories->id) . "' class='btn btn-tool'><i class='fas fa-pen'></i></a>
                <a href='javascript:;' class='btn btn-tool delete_" . $accessories->id . "' data-url='" . route('accessories.destroy', $accessories->id) . "'  onclick='deleteRecorded(" . $accessories->id . ")'><i class='fas fa-trash'></i></a>";
            })
            ->make(true);
    }

    public function getForDataTable($input)
    {

        $dataTableQuery = accessories::Leftjoin('accessories_categories as cc', 'accessories.category_id', '=', 'cc.id')->select('accessories.*', 'cc.title as category_title');

        if (isset($input['date']) && $input['date'] != '') {
            $from = explode(' - ', $input['date'])[0];
            $to = explode(' - ', $input['date'])[1];
            $from = date('Y-m-d', strtotime($from));
            $to = date('Y-m-d', strtotime($to));
            $dataTableQuery->whereBetween('accessories.created_at', [$from, $to]);
        }

        if (isset($input['cat_id']) && $input['cat_id'] != '') {
            $dataTableQuery->where('cc.id', '=', $input['cat_id']);
        }


        return  $dataTableQuery;
    }
}
