<?php

namespace Modules\Catering\Models;

use App\BaseModel;
use Modules\Setting\Models\Supply;
use Modules\Setting\Models\Unit;
use Modules\Setting\Models\Param;

class PreparationDetail extends BaseModel
{
    public $table = 'preparation_details';

    protected $fillable = [ 
        'food_id', //supply
        'preparation_id',
        'unit_id',
        'unit_type',
        'amount',
        'amount_m',
        'amount_s',
    ];

    protected $appends = [ 'unit_type_text', 'supply_id' ];

    public function getUnitTypeTextAttribute()
    {
        switch($this->unit_type)
        {
            case Param::UNIT_TYPE_UNIT: return 'UNIDAD';
            case Param::UNIT_TYPE_MASS: return 'MASA';
            case Param::UNIT_TYPE_VOLUME: return 'VOLUMEN';
            default: return 'X';
        }
    }

    public function getSupplyIdAttribute() 
    {
        return $this->attributes['food_id'];
    }

    public function setSupplyIdAttribute($value) 
    {
        return $this->attributes['food_id'] = $value;
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class)->withDefault();
    }

    public function supply()
    {
        return $this->belongsTo(Supply::class, 'food_id', 'id_insumo')->withDefault();
    }

    public function preparation()
    {
        return $this->belongsTo(Preparation::class);
    }
}
