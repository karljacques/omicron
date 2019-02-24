<?php

namespace App\Repositories;


use App\Ship;
use App\Storable;

interface CargoRepositoryInterface
{
    public function addStorableToShip(Ship $ship, Storable $storable, $quantity);

    public function removeStorableFromShip(Ship $ship, Storable $storable);

    public function changeStorableQuantity(Ship $ship, Storable $storable, $quantity);

    public function getStorableQuantity(Ship $ship, Storable $storable): int;
}
