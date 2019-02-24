<?php

namespace App\Repositories;


use App\Ship;
use App\Storable;

class CargoRepository implements CargoRepositoryInterface
{

    public function addStorableToShip(Ship $ship, Storable $storable, $quantity)
    {
        $ship->cargo()->attach($storable->id, ['quantity' => $quantity]);
    }
}
