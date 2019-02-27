<?php


namespace App\Services\Game\Ship;


use App\Exceptions\UserActionException;
use App\Repositories\CargoRepositoryInterface;
use App\Ship;
use App\Storable;

class CargoService implements CargoServiceInterface
{
    const FUEL_ID = 1;
    protected $cargo_repository;

    /**
     * CargoService constructor.
     *
     * @param CargoRepositoryInterface $cargo_repository
     */
    public function __construct(CargoRepositoryInterface $cargo_repository)
    {
        $this->cargo_repository = $cargo_repository;
    }

    /**
     * @param Ship     $ship
     * @param Storable $storable
     * @param int      $quantity
     *
     * @return bool
     * @throws UserActionException
     */
    public function addStorableToCargo(Ship $ship, Storable $storable, int $quantity): bool
    {
        // Does the ship have enough space?
        if ($ship->cargo + ($quantity * $storable->cargo_size) > $ship->max_cargo) {
            throw new UserActionException('There is not enough space in the cargo hold');
        }

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

        if ($quantity > 0) {
            $current_quantity = $this->cargo_repository->getStorableQuantity($ship, $storable);
            $this->cargo_repository->setStorableQuantity($ship, $storable, $quantity + $current_quantity);
        }

        $this->recalculateCargo($ship);

        return true;
    }

    /**
     * @param Ship $ship
     */
    public function recalculateCargo(Ship $ship): void
    {
        $cargo_quantity = $this->cargo_repository->calculateShipCargoUsage($ship);

        $ship->cargo = $cargo_quantity;
        $ship->save();
    }

    /**
     * @param Ship     $ship
     * @param Storable $storable
     * @param int      $quantity
     *
     * @return bool
     */
    public function removeStorableFromCargo(Ship $ship, Storable $storable, int $quantity): bool
    {
        $current_quantity = $this->cargo_repository->getStorableQuantity($ship, $storable);

        if ($current_quantity < $quantity)
            return false;

        $this->cargo_repository->setStorableQuantity($ship, $storable, $current_quantity - $quantity);

        $this->recalculateCargo($ship);
        return true;
    }
}
