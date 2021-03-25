<?php

namespace Modules\Catering\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgrammingResource extends JsonResource
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
            'date' => $this->date,
            'professional_id' => $this->professional_id,
            'regime_id' => $this->regime_id,
            'food_type_id' => $this->food_type_id,
            'warehouse_id' => $this->warehouse_id,

            'professional_fullname' => $this->professional->fullname,
            'regime_descrip' => $this->regime->descrip,
            'food_type_descrip' => $this->foodType->descrip,
            
            'programming_details' => $this->programmingDetails->map(function($item){
                return [
                    'preparation_id' => $item->preparation_id,
                    'preparation_descrip' => $item->preparation->descrip,
                    'portions' => (float)$item->portions,
                ];
            })
        ];
    }
}
