<?php

namespace App\Http\Controllers;

use App\Models\ComponentCategories;
use App\Models\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComponentCategoriesController extends Controller
{
    protected $upload_path;
    protected $storage;
    /**
     *
     */
    public function __construct()
    {

        $this->upload_path = 'img' . DIRECTORY_SEPARATOR . 'component-categories' . DIRECTORY_SEPARATOR;

        $this->storage = Storage::disk('public');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('component-categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $components = Component::where('category_id', NULL)->pluck('title', 'id')->toArray();
        return view('component-categories.create', compact('components'));
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
            'title.required' => 'Please enter Component Category title',
            'description.required' => 'Please enter Component Category description',
            'image.required' => 'Please select Component Category image',
            'is_active.required' => 'Please select components Status',
        ]);
        $input = $request->all();
        if (array_key_exists('image', $input) && !empty($input['image'])) {
            $input = $this->uploadImage($input, 'image');
        } else {
            $input['image'] = '';
        }
        $category = ComponentCategories::create([
            'title' =>  $input['title'],
            'description' =>  $input['description'],
            'image' =>  $input['image'],
            'is_active' =>  $input['is_active'],
        ]);
        if (isset($input['components']) && !empty($input['components'])) {
            foreach ($input['components'] as $component) {
                Component::where('id', $component)->update([
                    'category_id' => $category->id
                ]);
            }
        }
        return redirect()->route('component-categories.index')->with('notice', 'Component Category Added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ComponentCategories  $componentCategories
     * @return \Illuminate\Http\Response
     */
    public function show(ComponentCategories $componentCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ComponentCategories  $componentCategories
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $componentCategory = ComponentCategories::find($id);
        $selectedComponent = [];
        if (count($componentCategory->getComponents)) {
            foreach ($componentCategory->getComponents as   $component) {
                $selectedComponent[$component->id] = $component->title;
            }
            $components = Component::where('category_id', NULL)->pluck('title', 'id')->toArray();
        } else {
            $components = Component::where('category_id', NULL)->pluck('title', 'id')->toArray();
        }

        return view('component-categories.edit', compact('componentCategory', 'selectedComponent', 'components'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ComponentCategories  $componentCategories
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
            'title.required' => 'Please enter Component Category title',
            'description.required' => 'Please enter Component Category description',
            'image.required' => 'Please select Component Category image',
            'is_active.required' => 'Please select components Status',
        ]);
        $input = $request->all();

        $componentCategory = ComponentCategories::find($id);
        if (array_key_exists('image', $input) && !empty($input['image'])) {
            $this->deleteOldFile($componentCategory->image);
            $input = $this->uploadImage($input, 'image');
        } else {
            $input['image'] = $componentCategory->image;
        }
        $componentCategory->update([
            'title' =>  $input['title'],
            'description' =>  $input['description'],
            'image' =>  $input['image'],
            'is_active' =>  $input['is_active'],
        ]);

        if (isset($input['components']) && !empty($input['components'])) {
            if (count($componentCategory->getComponents)) {
                foreach ($componentCategory->getComponents as  $component) {
                    $component->update([
                        'category_id' => NULL
                    ]);
                }
                foreach ($input['components'] as $component) {
                    Component::where('id', $component)->update([
                        'category_id' => $componentCategory->id
                    ]);
                }
            } else {
                foreach ($input['components'] as $component) {
                    Component::where('id', $component)->update([
                        'category_id' => $componentCategory->id
                    ]);
                }
            }
        } else {
            if (count($componentCategory->getComponents)) {
                foreach ($componentCategory->getComponents as  $component) {
                    $component->update([
                        'category_id' => NULL
                    ]);
                }
            }
        }
        return redirect()->route('component-categories.index')->with('notice', 'Component Category Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComponentCategories  $componentCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $componentCategory = ComponentCategories::find($id);
        $this->deleteOldFile($componentCategory->image);
        $componentCategory->delete();
        if (count($componentCategory->getComponents)) {
            foreach ($componentCategory->getComponents as  $component) {
                $component->update([
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
        if (file_exists('public/img/component-categories/' . $fileName)) {
            @unlink(public_path() . '/' . $this->upload_path . $fileName);
        }
    }
}
