<?php

use App\Models\Component;
use App\Models\ComponentVisibility;
use App\Models\CustomBuildOverride;
use App\Models\CustomBuildComponentSortOrder;

if (!function_exists('getCustomBuildOverrideComponentVisibility')) {

    function getCustomBuildOverrideComponentVisibility($cate_id, $com_id, $custom_build_id)
    {
        return CustomBuildOverride::where('cat_id', $cate_id)->where('custom_build_id', $custom_build_id)->where('com_id', $com_id)->first();
    }
}
if (!function_exists('getCustomBuildComponentSortOrders')) {

    function getCustomBuildComponentSortOrders($cate_id, $custom_build_id)
    {
        return CustomBuildComponentSortOrder::where('category_id', $cate_id)->where('custom_build_id', $custom_build_id)->pluck('component_id', 'sort')->toArray();
    }
}

if (!function_exists('getCustomBuildComponentMarkAs')) {

    function getCustomBuildComponentMarkAs($cate_id, $custom_build_id)
    {
        return CustomBuildOverride::where('cat_id', $cate_id)->where('custom_build_id', $custom_build_id)->get(['com_id', 'mark_as']);
    }
}
if (!function_exists('getComponentBrands')) {

    function getComponentBrands($cate_id)
    {
        $data = Component::where('components.category_id', $cate_id)
            ->leftjoin('component_brands as b', 'b.id', '=', 'components.brand_id')
            // ->groupBy('components.category_id')
            ->get(['b.title', 'b.id'])->toArray();
        return array_unique($data, SORT_REGULAR);
    }
}
if (!function_exists('getVisibility')) {

    function getVisibility($custom_build_id)
    {
        $overrideConditions = CustomBuildOverride::where('custom_build_id', $custom_build_id)->get();
        $conditions = [];
        if (isset($overrideConditions) && !empty($overrideConditions)) {
            foreach ($overrideConditions as $val) {
                $componentConditions = ComponentVisibility::where('component_id', $val->com_id)->first();
                if ($val->conditions != 'null') {
                    $conditions[$val->com_id] = [
                        'conditions' => json_decode($val->conditions, true),
                        'message_on_disable' => $componentConditions->message_on_disable,
                    ];
                } else {
                    if (isset($componentConditions->conditions) && !empty($componentConditions->conditions)) {
                        $conditions[$val->com_id] = [
                            'conditions' => json_decode($componentConditions->conditions, true),
                            'message_on_disable' => $componentConditions->message_on_disable,
                        ];
                    }
                }
            }
        } else {
        }
        return json_encode($conditions);
        // if (isset($overrideConditions->conditions) && !empty($overrideConditions->conditions) && $overrideConditions->conditions != 'null') {
        //     $conditions = $overrideConditions->conditions;
        // } else {
        //     if (isset($componentConditions->conditions) && !empty($componentConditions->conditions)) {
        //         $conditions = $componentConditions->conditions;
        //     }
        // }
    }
}
