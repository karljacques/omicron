<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Station extends JsonResource
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
            'capacity' => $this->capacity,
            'id' => $this->id,
            'name' => $this->name,
            'position_x' => $this->position_x,
            'position_y' => $this->position_y,
            'system_id' => $this->system_id
        ];
    }
}
