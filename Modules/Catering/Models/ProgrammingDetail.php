<?php

namespace Modules\Catering\Models;

use App\BaseModel;

class ProgrammingDetail extends BaseModel
{
    public $table = 'programming_details';

    protected $fillable = [ 
        'programing_id',
        'preparation_id',
        'portions',
    ];

    public function programming()
    {
        return $this->belongsTo(Programming::class)->withDefault();
    }

    public function preparation()
    {
        return $this->belongsTo(Preparation::class)->withDefault();
    }
}
