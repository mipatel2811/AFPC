<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class PromotionDatatablesController extends Controller
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
            ->editColumn('image', function ($promotion) {
                if ($promotion->image != '') {
                    return "<img src='" . URL::to('/') . "/public/img/promotion/" . $promotion->image . "' height='100' width='100'/>";
                } else {
                    return "N/A";
                }
            })
            ->editColumn('is_active', function ($promotion) {
                if ($promotion->is_active == 1) {
                    return "<label class='badge bg-success'>Yes</label>";
                } else {
                    return "<label class='badge bg-warning'>No</label>";
                }
            })
            ->editColumn('created_at', function ($promotion) {
                return Carbon::parse($promotion->created_at)->format('F d, Y');
            })->addColumn('actions', function ($promotion) {
                return "<a href='" . route('promotion.edit', $promotion->id) . "' class='btn btn-tool'><i class='fas fa-pen'></i></a>
                <a href='javascript:;' class='btn btn-tool delete_" . $promotion->id . "' data-url='" . route('promotion.destroy', $promotion->id) . "'  onclick='deleteRecorded(" . $promotion->id . ")'><i class='fas fa-trash'></i></a>";
            })
            ->make(true);
    }

    public function getForDataTable($input)
    {
        $dataTableQuery = Promotion::select('promotions.*');
        return  $dataTableQuery;
    }
}
