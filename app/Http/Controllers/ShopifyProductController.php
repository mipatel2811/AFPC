<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ShopifyApiController;

class ShopifyProductController extends Controller
{
    protected $shopifyApi;

    public function __construct()
    {
        $this->shopifyApi = new ShopifyApiController();
    }

    public function createProduct($customBuild)
    {
        # code...
    }
    public function updateProduct()
    {
        # code...
    }
}
?>
