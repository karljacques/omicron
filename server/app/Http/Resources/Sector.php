<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Sector extends JsonResource
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
            'sector_type_id' => $this->sector_type_id,
            'system_id' => $this->system_id,
            'x' => $this->x,
            'y' => $this->y
        ];
    }
}
