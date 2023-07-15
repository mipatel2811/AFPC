<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function GuzzleHttp\json_decode;

class PromotionController extends Controller
{
    protected $upload_path;
    protected $storage;
    /**
     *
     */
    public function __construct()
    {

        $this->upload_path = 'img' . DIRECTORY_SEPARATOR . 'promotion' . DIRECTORY_SEPARATOR;

        $this->storage = Storage::disk('public');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('promotions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('promotions.create');
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
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'is_active' => 'required',
        ], [
            'title.required' => 'Please enter promotion title',
            'image.required' => 'Please select promotion image',
            'is_active.required' => 'Please select promotions Status',
        ]);
        $input = $request->all();


        if (array_key_exists('image', $input) && !empty($input['image'])) {
            $input = $this->uploadImage($input, 'image');
        } else {
            $input['image'] = '';
        }
        Promotion::create($input);
        return redirect()->route('promotion.index')->with('notice', 'Promotion Added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show(promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $promotion = Promotion::find($id);
        return view('promotions.edit', compact('promotion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg',
            'is_active' => 'required',
        ], [
            'title.required' => 'Please enter promotion title',
            'image.required' => 'Please select promotion image',
            'is_active.required' => 'Please select promotions Status',
        ]);
        $input = $request->all();
        $promotion = Promotion::find($id);
        if (array_key_exists('image', $input) && !empty($input['image'])) {
            $this->deleteOldFile($promotion->image);
            $input = $this->uploadImage($input, 'image');
        } else {
            $input['image'] = $promotion->image;
        }
        $promotion->update($input);
        return redirect()->route('promotion.index')->with('notice', 'Promotion Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $promotion = Promotion::find($id);
        $this->deleteOldFile($promotion->image);
        $promotion->delete();
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
        if (file_exists('public/img/promotion/' . $fileName)) {
            @unlink(public_path() . '/' . $this->upload_path . $fileName);
        }
    }
}
