<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Sector as SectorResource;

class System extends JsonResource
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
            'sectors'=>  SectorResource::collection($this->sectors),// TODO
            'size_x' => $this->size_x,
            'size_y' => $this->size_y
        ];
    }
}
