<?php


namespace App\Services\Game\Navigation;


use App\Dockable;
use App\Ship;

class DockingService implements DockingServiceInterface
{

    public function dock(Ship $ship, Dockable $dockable): bool
    {
        if (!$this->isEligibleToDock($ship, $dockable))
            return false;

        // Do dock
        $ship->docked_at = $dockable->id;
        $ship->save();

        return true;
    }

    public function undock(Ship $ship): bool
    {
        if ($ship->docked_at === null)
            return false;

        $ship->docked_at = null;
        $ship->save();

        return true;
    }

    protected function isEligibleToDock(Ship $ship, Dockable $dockable): bool
    {
        // Ensure ship isn't already docked
        if ($ship->docked_at !== null)
            return false;

        // Ensure ship and dockable aren't the same dockable
        if ($ship->id === $dockable->id)
            return false;

        // Ensure dockable and ship are at the same location
        if (!$ship->getPosition()->equal($dockable->getPosition()))
            return false;

        return true;
    }


}
