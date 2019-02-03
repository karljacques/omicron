<?php

namespace App\Repositories;


use App\Sector;
use App\Vector3;
use Illuminate\Support\Collection;

interface ShipRepositoryInterface
{
    public function getShipsInSector(Vector3 $sector) : Collection;
}
