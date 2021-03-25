<?php

namespace Modules\Setting\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Setting\Models\NutrientColumn;

class SupplyNutrientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $nutrient = $this->nutrient;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'estado' => $this->estado,
            
            'es_insumo' => $this->es_insumo,

            'unit_type' => $this->unit_type,
            'unit_type_text' => $this->unit_type_text,

            'supply_type_id' => $this->supply_type_id,
            'supply_type_descrip' => $this->supplyType->descrip,

            'net_weight' => $nutrient? $nutrient->net_weight: 0,
            'grams' => $nutrient? $nutrient->grams: 0,
            'nutrients' => $this->nutrientArray($nutrient)
        ];
    }

    public function nutrientArray($sNutrient)
    {
        $nutrientColumns = NutrientColumn::list();

        $array = [];
        foreach($nutrientColumns as $nutrientColumn){
            $label = $nutrientColumn->label;
            $colName = $nutrientColumn->column;

            $array[] = [
                'label' => $label,
                'column' => $colName,
                'value' => $sNutrient? $sNutrient->$colName: 0,
            ];
        }
        return $array;
    }
}
