<?php

namespace App\Services\Game\Navigation;


use App\Position;
use App\Repositories\SectorRepositoryInterface;
use App\Sector;
use App\Ship;
use App\System;

class PositionService implements PositionServiceInterface
{
    protected $sector_repository;

    public function __construct(SectorRepositoryInterface $sector_repository)
    {
        $this->sector_repository = $sector_repository;
    }

    public function move(Ship $ship, Position $delta): bool
    {
        if (!$this->isEligibleToMove($ship))
            return false;

        if ($delta->length() !== 1)
            return false;

        // Get the current sector and calculate fuel consumption
        $original_position = $ship->getPosition();
        $current_sector    = $this->sector_repository->getSectorAtPosition($original_position);

        // Cost is equal to sector_type_id to start with
        $move_cost = $current_sector->sector_type_id ?? 1;

        if ($ship->fuel < $move_cost)
            return false;

        // Calculate new position
        $ship->position_x += $delta->getX();
        $ship->position_y += $delta->getY();

        if (!$this->isPositionWithinSystemBounds($ship->getPosition(), $ship->system))
            return false;

        $ship->fuel -= $move_cost;
        $ship->save();

        return true;
    }

    protected function isEligibleToMove(Ship $ship): bool
    {
        return $ship->docked_at === null;
    }

    // This method doesn't current take into account the system_id - should it?
    protected function isPositionWithinSystemBounds(Position $position, System $system): bool
    {
        return $position->getX() <= $system->size_x
            && $position->getY() <= $system->size_y
            && $position->getX() > 0
            && $position->getY() > 0;
    }
}
