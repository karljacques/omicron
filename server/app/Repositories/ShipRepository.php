<?php

namespace App\Repositories;

use App\Position;
use App\Ship;
use Illuminate\Support\Collection;

class ShipRepository implements ShipRepositoryInterface
{
    public function getShipsInSector(Position $position): Collection
    {
        $ships_in_sector = Ship::where(
            [
                'system_id'  => $position->getSystemId(),
                'position_x' => $position->getX(),
                'position_y' => $position->getY(),
                'docked_at'  => null
            ])->get();

        return $ships_in_sector;
    }
}
