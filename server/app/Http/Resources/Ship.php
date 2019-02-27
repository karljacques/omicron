<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ship extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'docked_at' => $this->docked_at,

            'fuel'           => $this->fuel, // TODO: Only if you are the owner of this ship,
            'max_fuel'       => $this->max_fuel,
            'power'          => $this->power,
            'max_power'      => $this->max_power,
            'shields'        => $this->shields,
            'max_shields'    => $this->max_shields,
            'armour'         => $this->armour,
            'max_armour'     => $this->max_armour,
            'hit_points'     => $this->hit_points,
            'max_hit_points' => $this->max_hit_points,

            'id'           => $this->id,
            'name'         => $this->name,
            'position_x'   => $this->position_x,
            'position_y'   => $this->position_y,
            'ship_type_id' => $this->ship_type_id,
            'system_id'    => $this->system_id,
            'storables'    => $this->storables,

            'cargo'     => $this->cargo,
            'max_cargo' => $this->max_cargo
        ];
    }
}
