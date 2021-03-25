<?php

namespace Modules\Setting\Models;

use App\BaseModel;

class SupplyType extends BaseModel
{
    public $table = 'food_groups';

    protected $fillable = [ 
        'descrip',
        'abrev',
    ];
}
