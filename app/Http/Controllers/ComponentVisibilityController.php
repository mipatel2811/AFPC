<?php

namespace App\Http\Controllers;

use App\Models\ComponentVisibility;
use App\Models\ComponentCategories;
use App\Models\Component;
use Illuminate\Http\Request;

class ComponentVisibilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('component-visibilites.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $componentCategories = Component::pluck('title', 'id')->toArray();
        return view('component-visibilites.create', compact('componentCategories'));
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
            'component_id' => 'required',
            'description' => 'required',
            'message_on_disable' => 'required',
        ], [
            'component_id.required' => 'Please enter Component category',
            'description.required' => 'Please enter Component visibility description',
            'message_on_disable.required' => 'Please enter Message on disable',
        ]);

        $input = $request->all();
        if (isset($input['conditions'])) {
            ComponentVisibility::create([
                'component_id' => $input['component_id'],
                'description' =>  $input['description'],
                'message_on_disable' => $input['message_on_disable'],
                'conditions' => json_encode($input['conditions'], JSON_NUMERIC_CHECK)
            ]);
            return redirect()->route('component-visibilites.index')->with('notice', 'Component visibility Added successfully');
        } else {
            return redirect()->back()->with('error', 'Please add rule group');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ComponentVisibility  $componentVisibility
     * @return \Illuminate\Http\Response
     */
    public function show(ComponentVisibility $componentVisibility)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ComponentVisibility  $componentVisibility
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $component = ComponentVisibility::find($id);
        $componentCategories = Component::pluck('title', 'id')->toArray();
        return view('component-visibilites.edit', compact('componentCategories', 'component'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ComponentVisibility  $componentVisibility
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'component_id' => 'required',
            'description' => 'required',
            'message_on_disable' => 'required',
        ], [
            'component_id.required' => 'Please enter Component category',
            'description.required' => 'Please enter Component visibility description',
            'message_on_disable.required' => 'Please enter Message on disable',
        ]);
        $input = $request->all();
        if (isset($input['conditions'])) {
            $componentVisibility = ComponentVisibility::find($id);
            $componentVisibility->update([
                'component_id' => $input['component_id'],
                'description' => $input['description'],
                'message_on_disable' => $input['message_on_disable'],
                'conditions' => json_encode($input['conditions'], JSON_NUMERIC_CHECK)
            ]);
            return redirect()->route('component-visibilites.index')->with('notice', 'Component visibility Updated successfully');
        } else {
            return redirect()->back()->with('error', 'Please add rule group');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComponentVisibility  $componentVisibility
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $component = ComponentVisibility::find($id);
        $component->delete();
        return response()->json(['status' => 1]);
    }
}
