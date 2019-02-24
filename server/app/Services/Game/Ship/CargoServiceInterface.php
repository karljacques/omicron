<?php

namespace App\Services\Game\Ship;


use App\Ship;
use App\Storable;

interface CargoServiceInterface
{
    public function addStorableToCargo(Ship $ship, Storable $storable, int $quantity): bool;

    public function removeStorableFromCargo(Ship $ship, Storable $storable, int $quantity): bool;
}
