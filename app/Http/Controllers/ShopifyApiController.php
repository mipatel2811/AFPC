<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShopifyApiController extends Controller
{
    public $shop;

    public function __construct()
    {
        $this->shop = Auth::user();
    }

    public function shopifyGetApi($url)
    {
        return $this->shop->api()->rest('GET', $url)['body'];
    }
    public function shopifyPostApi($url,$data)
    {
        return $this->shop->api()->rest('POST', $url,$data);
    }
    public function shopifyUpdateApi($url,$data)
    {
        return $this->shop->api()->rest('PUT', $url,$data);
    }
    public function shopifyDeleteApi($url)
    {
        return $this->shop->api()->rest('DELETE', $url);
    }

    /**
     * Active Theme Id
     *
     * @return void
     */
    public function getThemeID()
    {

        $themes = $this->shopifyGetApi('/admin/themes.json')->container['themes'];
        foreach ($themes as $theme) {
            if ($theme['role'] === 'main') {
                $activeThemeId = $theme['id'];
            }
        }
        return $activeThemeId;
    }
}
