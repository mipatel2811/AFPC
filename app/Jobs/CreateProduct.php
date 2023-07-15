<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ShopifyApiController;
use App\Models\CustomBuild;
use App\Models\Component;
use App\Models\ComponentCategories;

class CreateProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $shopifyApi;
    protected $id;
    public function __construct($id)
    {
        $this->shopifyApi = new ShopifyApiController();
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $customBuild = CustomBuild::find($this->id);
        $tags = '';
        if ($customBuild->tags != ' ') {
            $tags = implode(', ', json_decode($customBuild->tags, true));
        }
        $variants = [];
        $options = [];
        foreach ($customBuild->getCustomBuildOverride as $key => $category) {
            $component = Component::where('id', $category->com_id)->first();

            if ($category->regular_price == '' && $category->special_price == '') {
                $special_price = $component->special_price;
                $regular_price = $component->regular_price;
            } elseif ($category->regular_price == '') {
                $regular_price = $component->regular_price;
            } elseif ($category->special_price == '') {
                $special_price = $component->special_price;
            } else {
                $regular_price = $category->regular_price;
                $special_price = $category->special_price;
            }
            if ($regular_price == '') {
                $regular_price = 0;
            } elseif ($special_price == '') {
                $special_price = 0;
            }

            $variants[$category->cat_id][] = [
                "title" => $component->title,
                "sku" => $component->sku,
                'price' => $regular_price,
                'inventory_quantity' => $component->stock,
            ];
        }
        $data = [];
        foreach ($variants as $keyOption => $variant) {
            $componentCategories = ComponentCategories::where('id', $keyOption)->first();
            $innerVar = [];
            $values = [];
            foreach ($variant as $key => $value) {
                $innerVar[] = [
                    "option" . ($key + 1) . "" => $value['title'],
                    "sku" => $value['sku'],
                    'price' => $value['price'],
                    'inventory_quantity' => $value['inventory_quantity'],
                ];
                $values[] = $value['title'];
            }
            $options[] = [
                "name" => $componentCategories->title,
                "values" => $values
            ];
            $data[$keyOption][] = [
                $innerVar,
                $options
            ];
        }
        // echo  '<pre>';
        // print_r($data);
        // echo '</pre>';
        // die();
        $product = [
            'product' => [
                "title" => $customBuild->title,
                "body_html" => $customBuild->description,
                "tags" => $tags,
                "variants" => $variants,
                "options" => $options,
            ],
        ];
        // $metafields = $this->shopifyApi->shopifyPostApi('/admin/api/2021-04/products.json', $product);
        // echo  '<pre>';
        // print_r($metafields);
        // echo '</pre>';
        // die();
        // if ($metafields['errors'] == 1) {
        //     foreach ($metafields['body'] as $key => $errors) {
        //         foreach ($errors as  $error) {
        //             $msg = '<p>' . $key . ': ' . $error  . '</p>';
        //             Log::info($msg);
        //         }
        //     }
        // }
    }
}
