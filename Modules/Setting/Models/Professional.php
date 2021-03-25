<?php

namespace Modules\Setting\Models;

use App\BaseModel;

class Professional extends BaseModel
{
    public $table = 'professionals';

    protected $fillable = [ 
        'fullname',
        'profession',
        'code',
    ];
}
