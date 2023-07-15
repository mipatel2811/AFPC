<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Accessories extends Model
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
        return $this->belongsTo(AccessoriesCategories::class, 'category_id', 'id');
    }
}
