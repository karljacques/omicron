<?php


namespace App\Services\Game\Ship;


use App\Repositories\CargoRepositoryInterface;
use App\Ship;
use App\Storable;

class CargoService implements CargoServiceInterface
{
    const FUEL_ID = 1;
    protected $cargo_repository;

    public function __construct(CargoRepositoryInterface $cargo_repository)
    {
        $this->cargo_repository = $cargo_repository;
    }

    public function addStorableToCargo(Ship $ship, Storable $storable, int $quantity): bool
    {
        if ($storable->id === self::FUEL_ID) {
            $space_in_tank = $ship->max_fuel - $ship->fuel;

            if ($quantity > $space_in_tank) {
                $to_add_to_tank = $space_in_tank;
                $quantity       -= $space_in_tank;
            } else {
                $to_add_to_tank = $quantity;
                $quantity       = 0;
            }

            $ship->fuel += $to_add_to_tank;
            $ship->save();
        }

        $current_quantity = $this->cargo_repository->getStorableQuantity($ship, $storable);
        if ($current_quantity > 0) {
            $this->cargo_repository->changeStorableQuantity($ship, $storable, $quantity + $current_quantity);
        } else {
            $this->cargo_repository->addStorableToShip($ship, $storable, $quantity);
        }
        return true;
    }

    public function removeStorableFromCargo(Ship $ship, Storable $storable, int $quantity): bool
    {
        $current_quantity = $this->cargo_repository->getStorableQuantity($ship, $storable);
        if ($current_quantity - $quantity > 0) {
            $this->cargo_repository->changeStorableQuantity($ship, $storable, $current_quantity - $quantity);
        } else {
            $this->cargo_repository->removeStorableFromShip($ship, $storable);
        }

        return true;
    }
}
