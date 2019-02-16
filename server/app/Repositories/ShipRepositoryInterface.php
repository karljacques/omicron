<?php

namespace App\Repositories;


use App\Position;
use Illuminate\Support\Collection;

interface ShipRepositoryInterface
{
    public function getShipsInSector(Position $position) : Collection;
}
