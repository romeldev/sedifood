<?php

namespace Modules\Setting\Models;

use App\BaseModel;

class Regime extends BaseModel
{
    public $table = 'regimes';

    protected $fillable = [ 
        'descrip',
        'company_id',
    ];
}
