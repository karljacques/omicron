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

        $this->cargo_repository->addStorableToShip($ship, $storable, $quantity);

        return true;
        // TODO: Implement addStorableToCargo() method.
    }

    public function removeStorableFromCargo(Ship $ship, Storable $storable, int $quantity): bool
    {
        // TODO: Implement removeStorableFromCargo() method.
    }
}
