<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComponentCategories extends Model
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
        return $this->hasMany(Component::class, 'category_id', 'id');
    }
}
