<?php

namespace Modules\Setting\Models;

use App\BaseModel0;

class Warehouse extends BaseModel0
{
    public $table = 'almacen';

    protected $primaryKey = 'id_almacen';

    protected $fillable = [ 
        'id_almacen',
        'id_empresa',
        'nombre',
        'direccion',
        'ciudad',
        'ubigeo',
        'telefono',
        'estado',
    ];

    protected $appends = [ 'id', 'name' ];

    public function getIdAttribute() 
    {
        return $this->attributes['id_almacen'];
    }

    public function setIdAttribute($value) 
    {
        return $this->attributes['id_almacen'] = $value;
    }

    public function getNameAttribute() 
    {
        return $this->attributes['nombre'];
    }

    public function setNameAttribute($value) 
    {
        return $this->attributes['nombre'] = $value;
    }
}
