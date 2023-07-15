<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComponentCategories;
use App\Models\ComponentVisibility;
use App\Models\Component;
use App\Models\CustomBuild;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $componentCategoryCount = ComponentCategories::count();
        $componentCount = Component::count();
        $componentVisibilityCount = ComponentVisibility::count();
        $customBuildCount = CustomBuild::count();

        return view('home', compact('componentCategoryCount', 'componentCount','componentVisibilityCount','customBuildCount'));
    }
}
