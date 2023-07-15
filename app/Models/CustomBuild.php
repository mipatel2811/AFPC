<?php

namespace App\Models;

use App\Models\Promotion;
use App\Models\CustomBuildOverride;
use App\Models\CustomBuildCategories;
use App\Models\TechnicalSpecification;
use App\Models\CustomBuildImageGallery;
use Illuminate\Database\Eloquent\Model;
use App\Models\CustomBuildCategorySortOrder;

class CustomBuild extends Model
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
    public function getCategory()
    {
        return $this->belongsTo(CustomBuildCategories::class, 'custom_build_category_id', 'id');
    }
    public function getImageGallery()
    {
        return $this->hasMany(CustomBuildImageGallery::class, 'custom_build_id', 'id');
    }
    public function getTechnicalSpecification()
    {
        return $this->hasMany(TechnicalSpecification::class, 'custom_build_id', 'id');
    }
    public function getCustomBuildOverride()
    {
        return $this->hasMany(CustomBuildOverride::class, 'custom_build_id', 'id');
    }
    public function getCustomBuildSortOrder()
    {
        return $this->hasMany(CustomBuildCategorySortOrder::class, 'custom_build_id', 'id');
    }
    public function getCustomBuildPromotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id', 'id');
    }
}
