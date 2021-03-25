<?php

namespace Modules\Setting\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'estado' => $this->estado,
            
            'es_insumo' => $this->es_insumo,

            'unit_type' => $this->unit_type,
            'unit_type_text' => $this->unit_type_text,

            'supply_type_id' => $this->supply_type_id,
            'supply_type_descrip' => $this->supplyType->descrip,
        ];
    }
}
