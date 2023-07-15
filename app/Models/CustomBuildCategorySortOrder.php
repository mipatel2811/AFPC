<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomBuildCategorySortOrder extends Model
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
}
