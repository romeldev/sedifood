<?php

namespace Modules\Setting\Models;

use App\BaseModel;

class PreparationType extends BaseModel
{
    public $table = 'preparation_types';

    protected $fillable = [ 
        'descrip',
    ];
}
