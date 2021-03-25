<?php

namespace Modules\Setting\Models;

use App\BaseModel;

class Unit extends BaseModel
{
    public $table = 'units';

    protected $fillable = [ 
        'name',
        'abrev',
        'factor',
        'type',
        'forever',
    ];

    protected $appends = [ 'type_text' ];

    public function getTypeTextAttribute()
    {
        switch($this->type)
        {
            case Param::UNIT_TYPE_UNIT: return 'UNIDAD';
            case Param::UNIT_TYPE_MASS: return 'MASA';
            case Param::UNIT_TYPE_VOLUME: return 'VOLUMEN';
            default: return 'X';
        }
    }
    
 
    public function unitMin()
    {
        return $this->hasOne(Unit::class, 'id', 'type');
    }


    public function unitM()
    {
        return $this->unitMin;
    }

    public function unitS()
    {
        if( $this->type==Param::UNIT_TYPE_UNIT ){
            return $this->unitMin;
        }else if( $this->type==Param::UNIT_TYPE_MASS ){
            return Unit::find(4); // kilo
        }else if( $this->type==Param::UNIT_TYPE_VOLUME ){
            return Unit::find(5); // litro
        }
        return null;
    }


}
