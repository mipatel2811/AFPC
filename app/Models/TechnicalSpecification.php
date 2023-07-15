<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalSpecification extends Model
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
