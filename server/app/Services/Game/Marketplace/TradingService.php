<?php

namespace App\Services\Game\Marketplace;


use App\Character;
use App\Commodity;
use App\Exceptions\UserActionException;
use App\Repositories\CommoditiesRepositoryInterface;
use App\Services\Game\Character\FinanceServiceInterface;
use App\Services\Game\Ship\CargoServiceInterface;

class TradingService implements TradingServiceInterface
{
    protected $commodities_repository;
    protected $finance_service;
    protected $cargo_service;

    /**
     * TradingService constructor.
     *
     * @param CommoditiesRepositoryInterface $commodities_repository
     * @param FinanceServiceInterface        $finance_service
     * @param CargoServiceInterface          $cargo_service
     */
    public function __construct(CommoditiesRepositoryInterface $commodities_repository, FinanceServiceInterface $finance_service, CargoServiceInterface $cargo_service)
    {
        $this->commodities_repository = $commodities_repository;
        $this->finance_service        = $finance_service;
        $this->cargo_service          = $cargo_service;
    }

    /**
     * @param Character $character
     * @param Commodity $commodity
     * @param int       $quantity
     * @param int       $price
     *
     * @throws UserActionException
     */
    public function buy(Character $character, Commodity $commodity, int $quantity, int $price): void
    {
        if ($quantity <= 0)
            throw new UserActionException('Quantity must be positive');
        
        $ship      = $character->ship;
        $docked_at = $ship->dockedAt;

        if (!$docked_at) {
            throw new UserActionException('Player not docked');
        }

        // Check the dockable sells your commodity
        $dockable_commodity = $this->commodities_repository->getCommoditySoldAtDockable($docked_at, $commodity);

        if (!$dockable_commodity) {
            throw new UserActionException('Not sold here');
        }

        if ($dockable_commodity->sell !== $price) {
            throw new UserActionException('Price mismatch');
        }

        $unit_cost  = $dockable_commodity->sell;
        $total_cost = $unit_cost * $quantity;

        if ($this->finance_service->canAfford($character, $total_cost)) {

            $this->cargo_service->addStorableToCargo($character->ship, $commodity, $quantity);
            $this->finance_service->charge($character, $total_cost);

        } else {
            throw new UserActionException('Cannot afford');
        }

    }

    /**
     * @param Character $character
     * @param Commodity $commodity
     * @param int       $quantity
     * @param int       $price
     *
     * @throws UserActionException
     */
    public function sell(Character $character, Commodity $commodity, int $quantity, int $price): void
    {
        if ($quantity <= 0)
            throw new UserActionException('Quantity must be positive');

        $ship      = $character->ship;
        $docked_at = $ship->dockedAt;

        if (!$docked_at) {
            throw new UserActionException('Player not docked');
        }

        // Check the dockable buys your commodity
        $dockable_commodity = $this->commodities_repository->getCommodityBoughtAtDockable($docked_at, $commodity);

        if (!$dockable_commodity) {
            throw new UserActionException('Not sold here');
        }

        if ($dockable_commodity->buy !== $price) {
            throw new UserActionException('Price mismatch');
        }

        $unit_cost    = $dockable_commodity->buy;
        $total_profit = $unit_cost * $quantity;

        $removed_from_cargo = $this->cargo_service->removeStorableFromCargo($character->ship, $commodity, $quantity);

        if ($removed_from_cargo) {
            $this->finance_service->credit($character, $total_profit);
        } else {
            throw new UserActionException('You do not have that cargo');
        }
    }
}
