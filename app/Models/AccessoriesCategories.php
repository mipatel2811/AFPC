<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AccessoriesCategories extends Model
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

    public function getAccessories()
    {
        return $this->hasMany(Accessories::class, 'category_id', 'id');
    }
}
