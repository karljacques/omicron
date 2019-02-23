<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Dockable extends JsonResource
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
            'system_id' => $this->system_id,
            'position_x' => $this->position_x,
            'position_y' => $this->position_y,
            'system' => [
                'id' => $this->system->id,
                'name' => $this->system->name
            ]
        ];
    }
}
