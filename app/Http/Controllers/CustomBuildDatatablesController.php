<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Models\CustomBuild;
use App\Models\Component;
use App\Models\ComponentVisibility;
use App\Models\CustomBuildCategories;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class CustomBuildDatatablesController extends Controller
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
            ->editColumn('image', function ($customBuild) {
                if (isset($customBuild->getImageGallery) && $customBuild->getImageGallery != '') {
                    $image = '';
                    foreach ($customBuild->getImageGallery as $key => $gallery) {
                        if ($key == 0) {
                            $image = $gallery->image;
                        }
                    }
                    if ($image != '') {
                        return "<img src='" . URL::to('/') . "/public/img/custom-build/gallery/" . $image . "' height='100' width='100'/>";
                    } else {
                        return "N/A";
                    }
                } else {
                    return "N/A";
                }
            })
            ->editColumn('is_active', function ($customBuild) {
                if ($customBuild->is_active == 1) {
                    return "<label class='badge bg-success'>Yes</label>";
                } else {
                    return "<label class='badge bg-warning'>No</label>";
                }
            })
            ->editColumn('tags', function ($customBuild) {
                if ($customBuild->tags != ' ') {
                    return implode(', ', json_decode($customBuild->tags, true));
                } else {
                    return "N/A";
                }
            })
            ->editColumn('created_at', function ($customBuild) {
                return Carbon::parse($customBuild->created_at)->format('F d, Y');
            })->addColumn('actions', function ($customBuild) {
                return "<a href='" . route('custom-build.edit', $customBuild->id) . "' class='btn btn-tool'><i class='fas fa-pen'></i></a>
                <a  href='javascript:;' class='btn btn-tool delete_" . $customBuild->id . "' data-url='" . route('custom-build.destroy', $customBuild->id) . "'  onclick='deleteRecorded(" . $customBuild->id . ")'><i class='fas fa-trash'></i></a>";
            })
            ->make(true);
    }
    public function getForDataTable($input)
    {

        $dataTableQuery = CustomBuild::Leftjoin('custom_build_categories as cc', 'custom_builds.custom_build_category_id', '=', 'cc.id')->select('custom_builds.*', 'cc.title as category_title');
        if (isset($input['date']) && $input['date'] != '') {
            $from = explode(' - ', $input['date'])[0];
            $to = explode(' - ', $input['date'])[1];
            $from = date('Y-m-d',strtotime($from));
            $to = date('Y-m-d',strtotime($to));
            $dataTableQuery->whereBetween('custom_builds.created_at', [$from, $to]);
        }
        if (isset($input['cat_id']) && $input['cat_id'] != '') {
            $dataTableQuery->where('custom_builds.custom_build_category_id', '=', $input['cat_id']);
        }

        return  $dataTableQuery;
    }

    public function restoreDefault($cat_id, $id)
    {
        $visibility_data = ComponentVisibility::where('component_id', $id)->first();
        $com_data = Component::where('id', $id)->first();
        if (isset($visibility_data)) {

            $components = Component::pluck('title', 'id')->toArray();
            $visibilityHtml = view('custom-build.restore', compact('visibility_data', 'id', 'components', 'cat_id'))->render();

            $response = [
                'com_data' => $com_data,
                'visibilityHtml' => $visibilityHtml
            ];
        } else {
            $response = [
                'com_data' => $com_data,
                'visibilityHtml' => 0
            ];
        }

        return response()->json($response);

        // return response()->json(['com_data' => $com_data, 'visibility_data' => $visibility_data]);

    }
    public function categoryRestoreDefault($cat_id)
    {
        $com_data = Component::where('category_id', $cat_id)->pluck('id');

        return response()->json($com_data);
    }
}
