<?php

namespace Modules\Setting\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplyTypeResource extends JsonResource
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
            'abrev' => $this->abrev,
        ];
    }
}
