<?php

namespace Modules\Setting\Models;

use App\BaseModel;

class Nutrient extends BaseModel
{
    public $table = 'nutrients';

    protected $fillable = [ 
        'food_id',
        'net_weight',
        'grams',
        // ...
    ];

    public function supply()
    {
        return $this->belongsTo(Supply::class, 'food_id', 'id');
    }

}
