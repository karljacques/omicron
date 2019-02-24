<?php

namespace App\Repositories;


use App\Ship;
use App\Storable;

class CargoRepository implements CargoRepositoryInterface
{

    public function addStorableToShip(Ship $ship, Storable $storable, $quantity)
    {
        $ship->storables()->attach($storable->id, ['quantity' => $quantity]);
    }

    public function removeStorableFromShip(Ship $ship, Storable $storable)
    {
        $ship->storables()->detach($storable->id);
    }

    public function changeStorableQuantity(Ship $ship, Storable $storable, $quantity)
    {
        // TODO: Implement changeStorableQuantity() method.
        $ship->storables()->updateExistingPivot($storable->id, ['quantity' => $quantity]);
    }

    public function getStorableQuantity(Ship $ship, Storable $storable): int
    {
        $cargo = $ship->storables()->where('id', $storable->id)->first();

        if (!$cargo) {
            return 0;
        }
        return $cargo->pivot->quantity;
    }
}
