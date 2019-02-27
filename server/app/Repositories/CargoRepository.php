<?php

namespace App\Repositories;


use App\Ship;
use App\Storable;

class CargoRepository implements CargoRepositoryInterface
{

    public function setStorableQuantity(Ship $ship, Storable $storable, int $quantity)
    {
        if ($quantity > 0) {
            $current_quantity = $this->getStorableQuantity($ship, $storable);

            if ($current_quantity > 0) {
                $this->changeStorableQuantity($ship, $storable, $quantity);
            } else {
                $this->addStorableToShip($ship, $storable, $quantity);
            }
        } else {
            $this->removeStorableFromShip($ship, $storable);
        }
    }

    public function getStorableQuantity(Ship $ship, Storable $storable): int
    {
        $cargo = $ship->storables()->where('id', $storable->id)->first();

        if (!$cargo) {
            return 0;
        }
        return $cargo->pivot->quantity;
    }

    protected function addStorableToShip(Ship $ship, Storable $storable, int $quantity)
    {
        $ship->storables()->attach($storable->id, ['quantity' => $quantity]);
    }

    protected function removeStorableFromShip(Ship $ship, Storable $storable)
    {
        $ship->storables()->detach($storable->id);
    }

    protected function changeStorableQuantity(Ship $ship, Storable $storable, int $quantity)
    {
        $ship->storables()->updateExistingPivot($storable->id, ['quantity' => $quantity]);
    }
}
