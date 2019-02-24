<?php

namespace App\Repositories;


use App\Ship;
use App\Storable;

interface CargoRepositoryInterface
{
    public function addStorableToShip(Ship $ship, Storable $storable, $quantity);
}
