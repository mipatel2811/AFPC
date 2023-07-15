<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Component;
use App\Jobs\CreateProduct;
use App\Models\CustomBuild;
use Illuminate\Http\Request;
use App\Models\ComponentCategories;
use App\Models\ComponentVisibility;
use App\Models\CustomBuildOverride;
use Illuminate\Support\Facades\URL;
use App\Models\CustomBuildCategories;
use App\Models\TechnicalSpecification;
use App\Models\CustomBuildImageGallery;
use Illuminate\Support\Facades\Storage;
use App\Models\CustomBuildCategorySortOrder;
use App\Models\CustomBuildComponentSortOrder;
use App\Http\Controllers\ShopifyProductController;

class CustomizerController extends Controller
{
    protected $gallery_upload_path;
    protected $video_upload_path;
    protected $storage;
    protected $shopifyProduct;
    /**
     *
     */
    public function __construct()
    {

        $this->gallery_upload_path = 'img' . DIRECTORY_SEPARATOR . 'custom-build/gallery' . DIRECTORY_SEPARATOR;
        $this->video_upload_path = 'img' . DIRECTORY_SEPARATOR . 'custom-build/video' . DIRECTORY_SEPARATOR;

        $this->storage = Storage::disk('public');
        $this->shopifyProduct = new ShopifyProductController();
    }

    public function getData($product_id, Request $request)
    {
        $product_type = 'base';
        if (isset($request->type)) {
            $product_type = $request->type;
        }
        $customBuild = CustomBuild::where('shopify_product_id', $product_id)->first();
        if (isset($customBuild)) {
            $id = $customBuild->id;
            // CreateProduct::dispatch($id);
            $technicalSpecification = TechnicalSpecification::where('custom_build_id', $id)->pluck('title', 'description')->toArray();
            $imageGallery = CustomBuildImageGallery::where('custom_build_id', $id)->pluck('image', 'id')->toArray();
            sort($imageGallery);
            $customBuildoverrideData = CustomBuildOverride::where('custom_build_id', $id)->get();

            $customBuildCategories = CustomBuildCategories::where('is_active', 1)->pluck('title', 'id')->toArray();
            $sort = CustomBuildCategorySortOrder::where('custom_build_id', $id)->orderBy('sort', 'ASC')->pluck('sort', 'custom_build_category_id')->toArray();
            $sortCate = array_flip($sort);
            $orders = array_map(function ($item) {
                return "id = {$item} DESC";
            }, $sortCate);
            $rawOrder = implode(', ', $orders);
            $componentCategories = ComponentCategories::where('is_active', 1)->orderByRaw($rawOrder)->get();

            $componentSelect = Component::where('is_active', 1)->pluck('title', 'id')->toArray();

            $customizerData = view('customizer.index', compact('customBuild', 'technicalSpecification', 'imageGallery', 'customBuildoverrideData', 'customBuildCategories', 'componentCategories', 'componentSelect', 'product_type'))->render();
            return response()->json(['status' => true, 'data' => $customizerData]);
        } else {
            return response()->json(['status' => false]);
        }
    }
    public function getConfigureData($product_id)
    {
        $customBuild = CustomBuild::where('shopify_product_id', $product_id)->first();
        if (isset($customBuild)) {
            $id = $customBuild->id;
            // CreateProduct::dispatch($id);
            // $technicalSpecification = TechnicalSpecification::where('custom_build_id', $id)->pluck('title', 'description')->toArray();
            // $imageGallery = CustomBuildImageGallery::where('custom_build_id', $id)->pluck('image', 'id')->toArray();
            // sort($imageGallery);
            // $customBuildoverrideData = CustomBuildOverride::where('custom_build_id', $id)->get();

            // $customBuildCategories = CustomBuildCategories::where('is_active', 1)->pluck('title', 'id')->toArray();
            $sort = CustomBuildCategorySortOrder::where('custom_build_id', $id)->orderBy('sort', 'ASC')->pluck('sort', 'custom_build_category_id')->toArray();
            $sortCate = array_flip($sort);
            $orders = array_map(function ($item) {
                return "id = {$item} DESC";
            }, $sortCate);
            $rawOrder = implode(', ', $orders);
            $componentCategories = ComponentCategories::where('is_active', 1)->orderByRaw($rawOrder)->get();

            // $componentSelect = Component::where('is_active', 1)->pluck('title', 'id')->toArray();



            $user = \DB::table('users')->first();
            Auth::loginUsingId($user->id, TRUE);
            $shop = Auth::user();
            $request_data =  '{
                product(id: "gid://shopify/Product/' . $product_id . '") {
                    onlineStorePreviewUrl
                }
              }';
            $res = $shop->api()->graph($request_data);
            if (isset($res['body']->container['data']['product']['onlineStorePreviewUrl'])) {
                $productURL = $res['body']->container['data']['product']['onlineStorePreviewUrl'];
                $base = view('customizer.configure-base', compact('customBuild', 'componentCategories', 'productURL'))->render();
                $recommended = view('customizer.configure-recommended', compact('customBuild', 'componentCategories', 'productURL'))->render();
                return response()->json(['status' => true, 'base' => $base, 'recommended' => $recommended]);
            } else {
                return response()->json(['status' => false]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
    public function getImagesGallery($product_id)
    {
        $customBuild = CustomBuild::where('shopify_product_id', $product_id)->first();
        if (isset($customBuild)) {
            $id = $customBuild->id;
            $imageGalleries = CustomBuildImageGallery::where('custom_build_id', $id)->pluck('image', 'id')->toArray();
            $gallery = view('customizer.image-gallery', compact('imageGalleries'))->render();
            return response()->json(['status' => true, 'gallery' => $gallery]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function getVisibility($custom_build_id, $com_id)
    {

        $overrideConditions = CustomBuildOverride::select('conditions')
            ->where('custom_build_id', $custom_build_id)->where('com_id', $com_id)->first();
        $componentConditions = ComponentVisibility::select('conditions')->where('component_id', $com_id)->first();

        $conditions = '';
        if (isset($overrideConditions->conditions) && !empty($overrideConditions->conditions) && $overrideConditions->conditions != 'null') {
            $conditions = $overrideConditions->conditions;
        } else {
            if (isset($componentConditions->conditions) && !empty($componentConditions->conditions)) {
                $conditions = $componentConditions->conditions;
            }
        }
        if (!empty($conditions)) {
            return response()->json(['status' => 1, 'conditions' => json_decode($conditions, true)]);
        } else {
            return response()->json(['status' => 0]);
        }
    }
}
