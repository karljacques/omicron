<?php

namespace App\Services\Game\Marketplace;


use App\Character;
use App\Commodity;
use App\Repositories\CommoditiesRepositoryInterface;
use App\Services\Game\Character\FinanceServiceInterface;
use App\Services\Game\Ship\CargoServiceInterface;

class TradingService implements TradingServiceInterface
{
    protected $commodities_repository;
    protected $finance_service;
    protected $cargo_service;

    public function __construct(CommoditiesRepositoryInterface $commodities_repository, FinanceServiceInterface $finance_service, CargoServiceInterface $cargo_service)
    {
        $this->commodities_repository = $commodities_repository;
        $this->finance_service        = $finance_service;
        $this->cargo_service          = $cargo_service;
    }

    public function buy(Character $character, Commodity $commodity, int $quantity, int $price)
    {
        $ship      = $character->ship;
        $docked_at = $ship->dockedAt;

        if (!$docked_at) {
            throw new \Exception('Player not docked');
            return false;
        }

        // Check the dockable sells your commodity
        $dockable_commodity = $this->commodities_repository->getCommoditySoldAtDockable($docked_at, $commodity);

        if (!$dockable_commodity) {
            throw new \Exception('Not sold here');
            return false;
        }

        if ($dockable_commodity->sell !== $price) {
            throw new \Exception('Price mismatch');
            return false;
        }

        $unit_cost  = $dockable_commodity->sell;
        $total_cost = $unit_cost * $quantity;

        if ($this->finance_service->canAfford($character, $total_cost)) {

            $this->cargo_service->addStorableToCargo($character->ship, $commodity, $quantity);
            $this->finance_service->charge($character, $total_cost);

            return true;
        } else {
            throw new \Exception('Cannot afford');
        }

        return false;
    }

    public function sell(Character $character, Commodity $commodity, int $quantity, int $price)
    {
        $ship      = $character->ship;
        $docked_at = $ship->dockedAt;

        if (!$docked_at) {
            throw new \Exception('Player not docked');
            return false;
        }

        // Check the dockable buys your commodity
        $dockable_commodity = $this->commodities_repository->getCommodityBoughtAtDockable($docked_at, $commodity);

        if (!$dockable_commodity) {
            throw new \Exception('Not sold here');
            return false;
        }

        if ($dockable_commodity->buy !== $price) {
            throw new \Exception('Price mismatch');
            return false;
        }

        // TODO: Check the user has the quantity they claim
        $unit_cost  = $dockable_commodity->buy;
        $total_profit = $unit_cost * $quantity;

        $this->cargo_service->removeStorableFromCargo($character->ship, $commodity, $quantity);
        $this->finance_service->credit($character, $total_profit);


        return true;
    }
}
