<?php

namespace App\Models;
use App\Models\ComponentVisibility;
use App\Models\CustomBuildOverride;
use App\Models\ComponentBrand;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $guarded = [];
    /**
     * Dates
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    // protected $appends = ['customBuildOverrideComponentVisibility'];
    
    public function getCategory()
    {
        return $this->belongsTo(ComponentCategories::class, 'category_id', 'id');
    }

    public function getBrand()
    {
        return $this->belongsTo(ComponentBrand::class, 'brand_id', 'id');
    }


    public function getComponentVisibility()
    {
        return $this->hasOne(ComponentVisibility::class, 'component_id', 'id');
    }
    public function getCustomBuildOverrideComponentVisibility()
    {
        return $this->hasOne(CustomBuildOverride::class, 'com_id', 'id');
    }
}
