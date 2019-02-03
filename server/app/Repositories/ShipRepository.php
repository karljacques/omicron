<?php

namespace App\Repositories;


use App\Sector;
use App\Vector3;
use App\Ship;
use Illuminate\Support\Collection;

class ShipRepository implements ShipRepositoryInterface
{
    public function getShipsInSector(Vector3 $sector): Collection
    {
        $system_id = $sector->z;

        $ships_in_sector = Ship::where(
            [
                'system_id'  => $system_id,
                'position_x' => $sector->x,
                'position_y' => $sector->y,
                'docked_at'  => null
            ])->get();

        return $ships_in_sector;
    }
}
