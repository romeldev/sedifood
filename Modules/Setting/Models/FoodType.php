<?php

namespace Modules\Setting\Models;

use App\BaseModel;

class FoodType extends BaseModel
{
    public $table = 'food_Types';

    protected $fillable = [ 
        'descrip',
    ];
}
