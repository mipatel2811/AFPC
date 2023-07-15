<?php

namespace App\Http\Controllers;

use App\Models\AccessoriesCategories;
use App\Models\Accessories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccessoriesCategoriesController extends Controller
{
    protected $upload_path;
    protected $storage;
    /**
     *
     */
    public function __construct()
    {

        $this->upload_path = 'img' . DIRECTORY_SEPARATOR . 'accessories-categories' . DIRECTORY_SEPARATOR;

        $this->storage = Storage::disk('public');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('accessories-categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accessories = Accessories::where('category_id', NULL)->pluck('title', 'id')->toArray();
        return view('accessories-categories.create', compact('accessories'));
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
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg',
            'is_active' => 'required',
        ], [
            'title.required' => 'Please enter Accessory Category title',
            'description.required' => 'Please enter Accessory Category description',
            'image.required' => 'Please select Accessory Category image',
            'is_active.required' => 'Please select Accessory Status',
        ]);
        $input = $request->all();
        if (array_key_exists('image', $input) && !empty($input['image'])) {
            $input = $this->uploadImage($input, 'image');
        } else {
            $input['image'] = '';
        }
        $category = AccessoriesCategories::create([
            'title' =>  $input['title'],
            'description' =>  $input['description'],
            'image' =>  $input['image'],
            'is_active' =>  $input['is_active'],
        ]);
        if (isset($input['accessories']) && !empty($input['accessories'])) {
            foreach ($input['accessories'] as $accessories) {
                Accessories::where('id', $accessories)->update([
                    'category_id' => $category->id
                ]);
            }
        }
        return redirect()->route('accessories-categories.index')->with('notice', 'Accessory Category Added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccessoriesCategories  $accessoriesCategories
     * @return \Illuminate\Http\Response
     */
    public function show(AccessoriesCategories $accessoriesCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccessoriesCategories  $accessoriesCategories
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $accessoryCategory = AccessoriesCategories::find($id);
        $selectedAccessory = [];
        if (count($accessoryCategory->getAccessories)) {
            foreach ($accessoryCategory->getAccessories as   $accessory) {
                $selectedAccessory[$accessory->id] = $accessory->title;
            }
            $accessories = Accessories::where('category_id', NULL)->pluck('title', 'id')->toArray();
        } else {
            $accessories = Accessories::where('category_id', NULL)->pluck('title', 'id')->toArray();
        }

        return view('accessories-categories.edit', compact('accessoryCategory', 'selectedAccessory', 'accessories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccessoriesCategories  $accessoriesCategories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg',
            'is_active' => 'required',
        ], [
            'title.required' => 'Please enter Accessory Category title',
            'description.required' => 'Please enter Accessory Category description',
            'image.required' => 'Please select Accessory Category image',
            'is_active.required' => 'Please select Accessory Status',
        ]);
        $input = $request->all();

        $accessoriesCategory = AccessoriesCategories::find($id);
        if (array_key_exists('image', $input) && !empty($input['image'])) {
            $this->deleteOldFile($accessoriesCategory->image);
            $input = $this->uploadImage($input, 'image');
        } else {
            $input['image'] = $accessoriesCategory->image;
        }
        $accessoriesCategory->update([
            'title' =>  $input['title'],
            'description' =>  $input['description'],
            'image' =>  $input['image'],
            'is_active' =>  $input['is_active'],
        ]);

        if (isset($input['accessories']) && !empty($input['accessories'])) {
            if (count($accessoriesCategory->getAccessories)) {
                foreach ($accessoriesCategory->getAccessories as  $accessories) {
                    $accessories->update([
                        'category_id' => NULL
                    ]);
                }
                foreach ($input['accessories'] as $accessories) {
                    Accessories::where('id', $accessories)->update([
                        'category_id' => $accessoriesCategory->id
                    ]);
                }
            } else {
                foreach ($input['accessories'] as $accessories) {
                    Accessories::where('id', $accessories)->update([
                        'category_id' => $accessoriesCategory->id
                    ]);
                }
            }
        } else {
            if (count($accessoriesCategory->getAccessories)) {
                foreach ($accessoriesCategory->getAccessories as  $accessories) {
                    $accessories->update([
                        'category_id' => NULL
                    ]);
                }
            }
        }
        return redirect()->route('accessories-categories.index')->with('notice', 'Accessory Category Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccessoriesCategories  $accessoriesCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $accessoriesCategory = AccessoriesCategories::find($id);
        $this->deleteOldFile($accessoriesCategory->image);
        $accessoriesCategory->delete();
        if (count($accessoriesCategory->getAccessories)) {
            foreach ($accessoriesCategory->getAccessories as  $accessories) {
                $accessories->update([
                    'category_id' => NULL
                ]);
            }
        }
        return response()->json(['status' => 1]);
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
        if (file_exists('public/img/accessories-categories/' . $fileName)) {
            @unlink(public_path() . '/' . $this->upload_path . $fileName);
        }
    }
}
