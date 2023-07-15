<?php

namespace App\Http\Controllers;

use App\Models\AccessoriesCategories;
use App\Models\Accessories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccessoriesController extends Controller
{
    protected $upload_path;
    protected $storage;
    /**
     *
     */
    public function __construct()
    {

        $this->upload_path = 'img' . DIRECTORY_SEPARATOR . 'accessories' . DIRECTORY_SEPARATOR;

        $this->storage = Storage::disk('public');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $accessoriesCategories = AccessoriesCategories::pluck('title', 'id')->toArray();
        return view('accessories.index', compact('accessoriesCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accessoriesCategories = AccessoriesCategories::pluck('title', 'id')->toArray();
        return view('accessories.create', compact('accessoriesCategories'));
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
            'description' => 'required',
            'sku' => 'required|unique:accessories',
            'regular_price' => 'required',
            'stock' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'is_active' => 'required',
        ], [
            'category_id.required' => 'Please enter Accessory category',
            'brand_id.required' => 'Please enter Accessory brand',
            'regular_price.required' => 'Please enter Accessory Regular Price',
            'stock.required' => 'Please enter Accessory stock',
            'title.required' => 'Please enter Accessory title',
            'description.required' => 'Please enter Accessory description',
            'image.required' => 'Please select Accessory image',
            'is_active.required' => 'Please select Accessory Status',
        ]);
        $input = $request->all();
        if (isset($input['category_id'])) {
            $category =  $this->addNewCategory($input);
            $input['category_id'] = $category->id;
        } else {
            $input['category_id'] = null;
        }
        if (array_key_exists('image', $input) && !empty($input['image'])) {
            $input = $this->uploadImage($input, 'image');
        } else {
            $input['image'] = '';
        }
        if (!isset($input['special_price'])) {
            $input['special_price'] = Null;
        }
        Accessories::create($input);
        return redirect()->route('accessories.index')->with('notice', 'accessories Added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\accessories  $accessories
     * @return \Illuminate\Http\Response
     */
    public function show(accessories $accessories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\accessories  $accessories
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $accessory = Accessories::find($id);
        $accessoriesCategories = AccessoriesCategories::pluck('title', 'id')->toArray();
        return view('accessories.edit', compact('accessoriesCategories', 'accessory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\accessories  $accessories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'sku' => 'required|unique:accessories,sku,' . $id,
            'regular_price' => 'required',
            'stock' => 'required|numeric',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg',
            'is_active' => 'required',
        ], [
            'category_id.required' => 'Please enter Accessory category',
            'brand_id.required' => 'Please enter Accessory brand',
            'regular_price.required' => 'Please enter Accessory Regular Price',
            'stock.required' => 'Please enter Accessory stock',
            'title.required' => 'Please enter Accessory title',
            'description.required' => 'Please enter Accessory description',
            'image.required' => 'Please select Accessory image',
            'is_active.required' => 'Please select Accessory Status',
        ]);
        $input = $request->all();
        if (!isset($input['category_id']) || empty($input['category_id'])) {
            $input['category_id'] = null;
        }

        $accessories = Accessories::find($id);
        if (!isset($input['special_price'])) {
            $input['special_price'] = Null;
        }
        if (array_key_exists('image', $input) && !empty($input['image'])) {
            $this->deleteOldFile($accessories->image);
            $input = $this->uploadImage($input, 'image');
        } else {
            $input['image'] = $accessories->image;
        }
        $accessories->update($input);
        return redirect()->route('accessories.index')->with('notice', 'accessories Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\accessories  $accessories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $accessories = Accessories::find($id);
        $this->deleteOldFile($accessories->image);
        $accessories->delete();
        return response()->json(['status' => 1]);
    }

    /**
     * Add new accessories Category
     *
     * @param array $input
     * @return object
     */
    public function addNewCategory($input)
    {
        $category = AccessoriesCategories::where('id', $input['category_id'])->first();
        if (!isset($category)) {
            $category = AccessoriesCategories::where('title', $input['category_id'])->first();
            if (isset($category)) {
                return $category;
            } else {
                $category = AccessoriesCategories::create([
                    'title' =>  $input['category_id'],
                    'description' =>  $input['category_id'],
                    'image' =>  '',
                    'is_active' =>  1,
                ]);
                return $category;
            }
        } else {
            return $category;
        }
    }

    /**
     * Upload Image.
     *
     * @param array $input
     *
     * @return array $input
     */
    public function uploadImage($input, $field)
    {
        if (isset($input[$field]) && !empty($input[$field])) {

            $image = $input[$field];

            $fileName = time() . '_' . $image->getClientOriginalName();

            $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));

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
        if (file_exists('public/img/accessories/' . $fileName)) {
            @unlink(public_path() . '/' . $this->upload_path . $fileName);
        }
    }
}
