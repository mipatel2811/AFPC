<?php

namespace App\Http\Controllers;
use App\Models\CustomBuildCategories;
use App\Models\Component;
use App\Models\ComponentBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComponentBrandController extends Controller
{

        protected $upload_path;
        protected $storage;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {

        $this->upload_path = 'img' . DIRECTORY_SEPARATOR . 'component-brand' . DIRECTORY_SEPARATOR;

        $this->storage = Storage::disk('public');
    }

    public function index()
    {
            return view('component-brand.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $components = ComponentBrand::pluck('title', 'id')->toArray();
        return view('component-brand.create', compact('components'));
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
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg',
            'is_active' => 'required',
        ], [
            'title.required' => 'Please enter Custom Build Category title',
            'image.required' => 'Please select Custom Build Category image',
            'is_active.required' => 'Please select Custom Build Category Status',
        ]);
        $input = $request->all();
        if (array_key_exists('image', $input) && !empty($input['image'])) {
            $input = $this->uploadImage($input, 'image');
        } else {
            $input['image'] = '';
        }
        $category = ComponentBrand::create([
            'title' =>  $input['title'],
            'image' =>  $input['image'],
            'is_active' =>  $input['is_active'],
        ]);

        return redirect()->route('component-brand.index')->with('notice', 'Component Brand Added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomBuildCategories  $customBuildCategories
     * @return \Illuminate\Http\Response
     */
    public function show(CustomBuildCategories $customBuildCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomBuildCategories  $customBuildCategories
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $componentCategory = ComponentBrand::find($id);
        
        return view('component-brand.edit', compact('componentCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomBuildCategories  $customBuildCategories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
            $this->validate($request, [
            'title' => 'required',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg',
            'is_active' => 'required',
        ], [
            'title.required' => 'Please enter Custom Build Category title',
            'image.required' => 'Please select Custom Build Category image',
            'is_active.required' => 'Please select Custom Build Category Status',
        ]);
        $input = $request->all();

        $componentCategory = ComponentBrand::find($id);
        if (array_key_exists('image', $input) && !empty($input['image'])) {
            $this->deleteOldFile($componentCategory->image);
            $input = $this->uploadImage($input, 'image');
        } else {
            $input['image'] = $componentCategory->image;
        }
        $componentCategory->update([
            'title' =>  $input['title'],
            'image' =>  $input['image'],
            'is_active' =>  $input['is_active'],
        ]);

        return redirect()->route('component-brand.index')->with('notice', 'Component Brand Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomBuildCategories  $customBuildCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $componentBrand = ComponentBrand::find($id);
        $this->deleteOldFile($componentBrand->image);
        $componentBrand->delete();
        return response()->json(['status' => 1]);
    }


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

    public function deleteOldFile($fileName)
    {
        if (file_exists('public/img/component-brand/' . $fileName)) {
            @unlink(public_path() . '/' . $this->upload_path . $fileName);
        }
    }

}
