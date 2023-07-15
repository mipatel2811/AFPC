<?php

namespace App\Http\Controllers;

use App\Models\ComponentCategories;
use App\Models\ComponentBrand;
use App\Models\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function GuzzleHttp\json_decode;

class ComponentController extends Controller
{
    protected $upload_path;
    protected $storage;
    /**
     *
     */
    public function __construct()
    {

        $this->upload_path = 'img' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR;

        $this->storage = Storage::disk('public');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $componentCategories = ComponentCategories::pluck('title', 'id')->toArray();
        return view('components.index', compact('componentCategories'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $componentCategories = ComponentCategories::pluck('title', 'id')->toArray();
        $componentBrands = ComponentBrand::pluck('title', 'id')->toArray();
        return view('components.create', compact('componentCategories','componentBrands'));
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
            'sku' => 'required|unique:components',
            'regular_price' => 'required',
            'stock' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'is_active' => 'required',
        ], [
            'category_id.required' => 'Please enter Component category',
            'brand_id.required' => 'Please enter Component brand',
            'regular_price.required' => 'Please enter Component Regular Price',
            'stock.required' => 'Please enter Component stock',
            'title.required' => 'Please enter Component title',
            'description.required' => 'Please enter Component description',
            'image.required' => 'Please select Component image',
            'is_active.required' => 'Please select components Status',
        ]);
        $input = $request->all();
        if (isset($input['category_id'])) {
            $category =  $this->addNewCategory($input);
            $input['category_id'] = $category->id;
        } else {
            $input['category_id'] = null;
        }

        if (isset($input['brand_id'])) {
            $input['brand_id'] = $input['brand_id'];
        } else {
            $input['brand_id'] = null;
        }

        if (array_key_exists('image', $input) && !empty($input['image'])) {
            $input = $this->uploadImage($input, 'image');
        } else {
            $input['image'] = '';
        }
        if (!isset($input['special_price'])) {
            $input['special_price'] = Null;
        }
        Component::create($input);
        return redirect()->route('components.index')->with('notice', 'Component Added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Component  $component
     * @return \Illuminate\Http\Response
     */
    public function show(Component $component)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Component  $component
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $component = Component::find($id);
        $componentCategories = ComponentCategories::pluck('title', 'id')->toArray();
        $componentBrands = ComponentBrand::pluck('title', 'id')->toArray();
        return view('components.edit', compact('componentCategories', 'component','componentBrands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Component  $component
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'sku' => 'required|unique:components,sku,' . $id,
            'regular_price' => 'required',
            'stock' => 'required|numeric',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg',
            'is_active' => 'required',
        ], [
            'category_id.required' => 'Please enter Component category',
            'brand_id.required' => 'Please enter Component brand',
            'regular_price.required' => 'Please enter Component Regular Price',
            'stock.required' => 'Please enter Component stock',
            'title.required' => 'Please enter Component title',
            'description.required' => 'Please enter Component description',
            'image.required' => 'Please select Component image',
            'is_active.required' => 'Please select components Status',
        ]);
        $input = $request->all();
        if (!isset($input['category_id']) || empty($input['category_id'])) {
            $input['category_id'] = null;
        }

        if (!isset($input['brand_id']) && !empty($input['brand_id'])) {
            $input['brand_id'] = $input['brand_id'];
        }

        $component = Component::find($id);
        if (!isset($input['special_price'])) {
            $input['special_price'] = Null;
        }
        if (array_key_exists('image', $input) && !empty($input['image'])) {
            $this->deleteOldFile($component->image);
            $input = $this->uploadImage($input, 'image');
        } else {
            $input['image'] = $component->image;
        }
        $component->update($input);
        return redirect()->route('components.index')->with('notice', 'Component Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Component  $component
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $component = Component::find($id);
        $this->deleteOldFile($component->image);
        $component->delete();
        return response()->json(['status' => 1]);
    }

    /**
     * Add new Component Category
     *
     * @param array $input
     * @return object
     */
    public function addNewCategory($input)
    {
        $category = ComponentCategories::where('id', $input['category_id'])->first();
        if (!isset($category)) {
            $category = ComponentCategories::where('title', $input['category_id'])->first();
            if (isset($category)) {
                return $category;
            } else {
                $category = ComponentCategories::create([
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
        if (file_exists('public/img/components/' . $fileName)) {
            @unlink(public_path() . '/' . $this->upload_path . $fileName);
        }
    }
}
