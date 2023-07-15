<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Component;
use App\Jobs\CreateProduct;
use App\Models\CustomBuild;
use Illuminate\Http\Request;
use App\Models\ComponentCategories;
use App\Models\ComponentVisibility;
use App\Models\CustomBuildOverride;
use App\Models\CustomBuildCategories;
use App\Models\TechnicalSpecification;
use App\Models\CustomBuildImageGallery;
use Illuminate\Support\Facades\Storage;
use App\Models\CustomBuildCategorySortOrder;
use App\Models\CustomBuildComponentSortOrder;
use App\Http\Controllers\ShopifyProductController;
use App\Models\Promotion;

class CustomBuildController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customBuildCategories = CustomBuildCategories::where('is_active', 1)->pluck('title', 'id')->toArray();
        return view('custom-build.index', compact('customBuildCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $customBuildCategories = CustomBuildCategories::where('is_active', 1)->pluck('title', 'id')->toArray();
        $componentCategories = ComponentCategories::where('is_active', 1)->get();

        $componentSelect = Component::where('is_active', 1)->pluck('title', 'id')->toArray();
        $promotions = Promotion::where('is_active', 1)->pluck('title', 'id')->toArray();

        // $componentSelect = Component::all()
        // ->map(function($item){
        //         return collect($item)->only('id','title','regular_price','special_price');
        // });

        return view('custom-build.create', compact('customBuildCategories', 'componentCategories', 'componentSelect', 'promotions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'custom_build_category_id' => 'required',
            'description' => 'required',
            'tags.*' => 'required',
            'sku' => 'required|unique:custom_builds',
            'image' => 'image|mimes:jpeg,png,jpg',
            'is_active' => 'required',
        ], [
            'custom_build_category_id.required' => 'Please enter Custom Build Category',
            // 'regular_price.required' => 'Please enter Custom Build Regular Price',
            'title.required' => 'Please enter Custom Build title',
            'sku.required' => 'Please enter Custom Build sku',
            'tags.*.required' => 'Please enter Custom Build tag',
            'description.required' => 'Please enter Custom Build description',
            'image.required' => 'Please select Custom Build image',
            'is_active.required' => 'Please select Custom Builds Status',
        ]);

        $input = $request->all();

        if ($input['product_video'] != 0) {

            if (array_key_exists('video', $input) && !empty($input['video'])) {
                $input = $this->uploadVideo($input, 'video');
            } else {
                $input['video'] = null;
                $input['video_title'] = null;
            }
        } else {
            $input['video'] = null;
            $input['video_title'] = null;
        }
        if (isset($input['promotion_id'])) {
            $input['promotion_id'] = $input['promotion_id'];
        } else {
            $input['promotion_id'] = null;
        }

        $customBuild = CustomBuild::create([
            'custom_build_category_id' =>  $input['custom_build_category_id'],
            'title' =>  $input['title'],
            'description' =>  $input['description'],
            'sku' =>  $input['sku'],
            'is_active' =>  $input['is_active'],
            'video_title' =>  $input['video_title'],
            'video' =>  $input['video'],
            'promotion_id' =>  $input['promotion_id'],
            'tags' =>  json_encode($input['tags']),
        ]);
        $tempData = str_replace("\\", "", $input['customBuildCatSort']);
        $cleanData = json_decode($tempData);
        foreach ($cleanData as $key => $value) {
            CustomBuildCategorySortOrder::create([
                'custom_build_id' => $customBuild->id,
                'custom_build_category_id' => $value,
                'sort' => $key
            ]);
        }
        $compoTempData = str_replace("\\", "", $input['childSort']);
        foreach ($compoTempData as $key => $value) {
            $compoTempDataInner = json_decode($value, true);
            foreach ($compoTempDataInner as $innerKey => $valueInner) {
                CustomBuildComponentSortOrder::create([
                    'custom_build_id' => $customBuild->id,
                    'category_id' =>  $key,
                    'component_id' => $valueInner,
                    'sort' => $innerKey
                ]);
            }
        }

        if ($input['technical_specification'] == 1) {
            foreach ($input['technical_specification_value'] as $technical_specification_value) {
                TechnicalSpecification::create([
                    'custom_build_id' =>  $customBuild->id,
                    'title' =>  $technical_specification_value[0],
                    'description' =>  $technical_specification_value[1],
                ]);
            }
        }

        if (!empty($input['images'])) {
            foreach ($input['images'] as $image) {
                $fileName = time() . '_' . $image->getClientOriginalName();
                $this->storage->put($this->gallery_upload_path . $fileName, file_get_contents($image->getRealPath()));
                CustomBuildImageGallery::create([
                    'custom_build_id' =>  $customBuild->id,
                    'image' =>  $fileName,
                ]);
            }
        } else {
            $input['image'] = '';
        }


        if (!empty($input['customBuild'])) {
            $this->addCustomBuildOverride($input['customBuild'], $customBuild->id);
        }

        $res = $this->addProduct($request->all());
        if (isset($res['body']->container['data']['productCreate']['product'])) {
            $customBuild->update([
                'shopify_product_id' => $res['body']->container['data']['productCreate']['product']['legacyResourceId'],
                'shopify_product_gid' => $res['body']->container['data']['productCreate']['product']['id'],
            ]);
        }
        \Log::info($res);

        return redirect()->route('custom-build.index')->with('notice', 'Custom Build added successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomBuild  $customBuild
     * @return \Illuminate\Http\Response
     */
    public function show(CustomBuild $customBuild)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomBuild  $customBuild
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $customBuild = CustomBuild::find($id);
        // CreateProduct::dispatch($id);
        $technicalSpecification = TechnicalSpecification::where('custom_build_id', $id)->pluck('title', 'description')->toArray();
        $imageGallery = CustomBuildImageGallery::where('custom_build_id', $id)->pluck('image', 'id')->toArray();
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
        $promotions = Promotion::where('is_active', 1)->pluck('title', 'id')->toArray();

        return view('custom-build.edit', compact('customBuild', 'technicalSpecification', 'imageGallery', 'customBuildoverrideData', 'customBuildCategories', 'componentCategories', 'componentSelect', 'promotions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomBuild  $customBuild
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $customBuild = CustomBuild::find($id);
        $this->validate($request, [
            'title' => 'required',
            'custom_build_category_id' => 'required',
            'description' => 'required',
            'tags.*' => 'required',
            'sku' => 'required|unique:custom_builds,sku,' . $customBuild->id,
            'image' => 'image|mimes:jpeg,png,jpg',
            'is_active' => 'required',
        ], [
            'custom_build_category_id.required' => 'Please enter Custom Build Category',
            // 'regular_price.required' => 'Please enter Custom Build Regular Price',
            'title.required' => 'Please enter Custom Build title',
            'sku.required' => 'Please enter Custom Build sku',
            'tags.*.required' => 'Please enter Custom Build tag',
            'description.required' => 'Please enter Custom Build description',
            'image.required' => 'Please select Custom Build image',
            'is_active.required' => 'Please select Custom Builds Status',
        ]);

        $input = $request->all();
        if ($input['product_video'] != 0) {

            if (array_key_exists('video', $input) && !empty($input['video'])) {
                $input = $this->uploadVideo($input, 'video');
            } else {
                $input['video'] = $customBuild->video;
                $input['video_title'] = $customBuild->video_title;
            }
        } else {
            $input['video'] = $customBuild->video;
            $input['video_title'] = $customBuild->video_title;
        }
        if (isset($input['promotion_id'])) {
            $input['promotion_id'] = $input['promotion_id'];
        } else {
            $input['promotion_id'] = $customBuild->promotion_id;
        }

        $customBuild->update([
            'custom_build_category_id' =>  $input['custom_build_category_id'],
            'title' =>  $input['title'],
            'description' =>  $input['description'],
            'sku' =>  $input['sku'],
            'is_active' =>  $input['is_active'],
            'video_title' =>  $input['video_title'],
            'video' =>  $input['video'],
            'promotion_id' =>  $input['promotion_id'],
            'tags' =>  json_encode($input['tags']),
        ]);
        $tempData = str_replace("\\", "", $input['customBuildCatSort']);
        $cleanData = json_decode($tempData);
        CustomBuildCategorySortOrder::where('custom_build_id', $customBuild->id)->delete();
        foreach ($cleanData as $key => $value) {
            CustomBuildCategorySortOrder::create([
                'custom_build_id' => $customBuild->id,
                'custom_build_category_id' => $value,
                'sort' => $key
            ]);
        }
        $compoTempData = str_replace("\\", "", $input['childSort']);
        CustomBuildComponentSortOrder::where('custom_build_id', $customBuild->id)->delete();
        foreach ($compoTempData as $key => $value) {
            $compoTempDataInner = json_decode($value, true);
            foreach ($compoTempDataInner as $innerKey => $valueInner) {
                CustomBuildComponentSortOrder::create([
                    'custom_build_id' => $customBuild->id,
                    'category_id' =>  $key,
                    'component_id' => $valueInner,
                    'sort' => $innerKey
                ]);
            }
        }
        if ($input['technical_specification'] == 1) {
            TechnicalSpecification::where('custom_build_id', $customBuild->id)->delete();
            foreach ($input['technical_specification_value'] as $technical_specification_value) {
                TechnicalSpecification::create([
                    'custom_build_id' =>  $customBuild->id,
                    'title' =>  $technical_specification_value[0],
                    'description' =>  $technical_specification_value[1],
                ]);
            }
        } else {
            TechnicalSpecification::where('custom_build_id', $customBuild->id)->delete();
        }

        if (!empty($input['images'])) {
            foreach ($input['images'] as $image) {
                $fileName = time() . '_' . $image->getClientOriginalName();
                $this->storage->put($this->gallery_upload_path . $fileName, file_get_contents($image->getRealPath()));
                CustomBuildImageGallery::create([
                    'custom_build_id' =>  $customBuild->id,
                    'image' =>  $fileName,
                ]);
            }
        }


        if (!empty($input['customBuild'])) {
            CustomBuildOverride::where('custom_build_id', $customBuild->id)->delete();
            $this->addCustomBuildOverride($input['customBuild'], $customBuild->id);
        }
        return redirect()->route('custom-build.index')->with('notice', 'Custom Build update successfully');
    }


    public function addCustomBuildOverride($customBuild, $customBuildId)
    {

        foreach ($customBuild as $cat_id => $customBuildData) {
            foreach ($customBuildData as $com_id => $componentData) {

                if (!isset($componentData['regular_price']) || $componentData['regular_price'] == '') {
                    $regular_price = 0;
                } else {
                    $regular_price = $componentData['regular_price'];
                }
                if (!isset($componentData['special_price']) || $componentData['special_price'] == '') {
                    $special_price = 0;
                } else {
                    $special_price = $componentData['special_price'];
                }

                if (!isset($componentData['conditions']) || $componentData['conditions'] == '') {
                    $conditions = null;
                } else {
                    $conditions = $componentData['conditions'];
                }
                if (!isset($componentData['is_enable']) || $componentData['is_enable'] == '') {
                    $is_enable = 0;
                } else {
                    $is_enable = $componentData['is_enable'];
                }

                if (!isset($componentData['mark_as']) || empty($componentData['mark_as'])) {
                    $mark_as = null;
                } else {
                    $mark_as = $componentData['mark_as'];
                }

                if (isset($customBuildData['is_enable'])) {
                    $cat_status = $customBuildData['is_enable'];
                } else {
                    $cat_status = 0;
                }
                if ($com_id != 'is_enable') {
                    CustomBuildOverride::create([
                        'custom_build_id' =>  $customBuildId,
                        'cat_id' => $cat_id,
                        'com_id' => $com_id,
                        'conditions' => json_encode($conditions, JSON_NUMERIC_CHECK),
                        'regular_price' => $regular_price,
                        'special_price' => $special_price,
                        'is_enable' => $is_enable,
                        'cat_status' => $cat_status,
                        'mark_as' => json_encode($mark_as),
                    ]);
                }
            }
        }
        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\  $customBuild
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customBuild = CustomBuild::find($id);
        $customBuild->delete();
        CustomBuildOverride::where('custom_build_id', $id)->delete();
        CustomBuildImageGallery::where('custom_build_id', $id)->delete();
        TechnicalSpecification::where('custom_build_id', $id)->delete();

        return response()->json(['status' => 1]);
    }

    /**
     * Upload Image.
     *
     * @param array $input
     *
     * @return array $input
     */
    public function uploadVideo($input, $field)
    {
        if (isset($input[$field]) && !empty($input[$field])) {

            $image = $input[$field];

            $fileName = time() . '_' . $image->getClientOriginalName();

            $this->storage->put($this->video_upload_path . $fileName, file_get_contents($image->getRealPath()));

            $input[$field] = $fileName;
            return $input;
        }
    }


    /**
     * Destroy Old Image.
     *
     * @param $fileName
     */
    public function deleteOldFile($fileName)
    {
        if (file_exists('public/img/components/' . $fileName)) {
            @unlink(public_path() . '/' . $this->upload_path . $fileName);
        }
    }



    public function addProduct($input)
    {
        $shop = Auth::user();
        $request_data =  'mutation productCreate($input: ProductInput!) {
                productCreate(input: $input) {
                  product {
                    id
                    legacyResourceId
                  }
                  shop {
                    id
                  }
                  userErrors {
                    field
                    message
                  }
                }
              }';
        $dateTime = Carbon::now();

        $input =  array(
            'input' => array(
                'title' => $input['title'],
                'descriptionHtml' => $input['description'],
                'tags' => implode(",", $input['tags']),
                "publishDate" => $dateTime->toIso8601String()
            ),
        );
        return $shop->api()->graph($request_data, $input);
    }
}
