<?php

namespace Modules\Catering\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PreparationResource extends JsonResource
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
            'descrip' => $this->descrip,
            'preparation_type_id' => $this->preparation_type_id,
            'warehouse_id' => $this->warehouse_id,
            'preparation_type' => $this->preparationType,

            'preparation_details' => $this->preparationDetails->map(function($pd){
                return [
                    'supply_name' => $pd->supply->name,
                    'supply_id' => $pd->supply_id,
                    'unit_id' => $pd->unit_id,
                    'unit_abrev' => $pd->unit->abrev,
                    'amount' => (float) $pd->amount,
                ];
            })
        ];
    }
}
