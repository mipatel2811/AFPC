<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ComponentBrand extends Model
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


    public function getComponents()
    {
        return $this->hasMany(Component::class, 'brand_id', 'id');
    }
}
