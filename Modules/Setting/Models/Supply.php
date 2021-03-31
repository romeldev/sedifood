<?php

namespace Modules\Setting\Models;

use App\BaseModel0;

class Supply extends BaseModel0
{
    public $table = 'insumo';

    protected $primaryKey = 'id_insumo';

    protected $fillable = [ 
        'nombre',           //name
        'id_unidades',
        'estado',
        'food_group_id',    //supply_type_id
        'unit_type',
        'es_insumo',
    ];

    protected $appends = [ 'name', 'id' ];

    public function scopeSearch( $query, $search )
    {
        if( trim($search) != ''){
            return $query->where('nombre', 'like', "%$search%");
        }
    }

    public function getIdAttribute() 
    {
        return $this->attributes['id_insumo'];
    }

    public function setIdAttribute($value) 
    {
        return $this->attributes['id_insumo'] = $value;
    }

    public function getSupplyTypeIdAttribute() 
    {
        return $this->attributes['food_group_id'];
    }

    public function setNameAttribute($value) 
    {
        return $this->attributes['nombre'] = $value;
    }

    public function getNameAttribute() 
    {
        return $this->attributes['nombre'];
    }

    public function setSupplyTypeIdAttribute($value) 
    {
        return $this->attributes['food_group_id'] = $value;
    }

    public function getUnitTypeTextAttribute()
    {
        switch($this->unit_type)
        {
            case Param::UNIT_TYPE_UNIT: return 'U';
            case Param::UNIT_TYPE_MASS: return 'M';
            case Param::UNIT_TYPE_VOLUME: return 'V';
            default: return 'X';
        }
    }

    public function supplyType()
    {
        return $this->belongsTo(SupplyType::class, 'food_group_id', 'id');
    }

    public function nutrient()
    {
        return $this->hasOne(Nutrient::class, 'food_id', 'id_insumo');
    }

    public function saveNutrient($htmlTable)
    {
        $supply = $this;

        $nutrient = $supply->nutrient? $supply->nutrient: new Nutrient();
        $nutrient->food_id = $supply->id;
        $nutrient->grams = request()->grams;
        $nutrient->net_weight = request()->net_weight;

        $nutrientColumns = NutrientColumn::list();

        $htmlTable = collect($htmlTable);

        foreach($nutrientColumns as $nutrientColumn){
            $colName = $nutrientColumn->column;
            $value = 0;

            $row = $htmlTable->firstWhere('column', $colName);
            if( $row && $row['value']) $value = $row['value'];
            $nutrient->$colName = $value? $value: 0;
        }

        $nutrient->save();
        return $nutrient;
    }


}
