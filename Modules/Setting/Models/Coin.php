<?php

namespace Modules\Setting\Models;

use App\BaseModel0;

class Coin extends BaseModel0
{
    public $table = 'monedas';

    protected $primaryKey = 'id_moneda';

    protected $fillable = [ 
        'nombre',
        'abreviado',
    ];

    public function getIdAttribute() 
    {
        return $this->attributes['id_moneda'];
    }

    public function setIdAttribute($value) 
    {
        return $this->attributes['id_moneda'] = $value;
    }

    public function getNameAttribute() 
    {
        return $this->attributes['nombre'];
    }

    public function setNameAttribute($value) 
    {
        return $this->attributes['nombre'] = $value;
    }

    public function getAbrevAttribute() 
    {
        return $this->attributes['abreviado'];
    }

    public function setAbrevAttribute($value) 
    {
        return $this->attributes['abreviado'] = $value;
    }
}
