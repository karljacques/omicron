<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DockableCommodity extends JsonResource
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
            'buy' => $this->buy,
            'sell' => $this->sell,
            'stock' => $this->stock,
            'commodity' => $this->commodity,
            'commodity_id' => $this->commodity_id
        ];
    }
}
