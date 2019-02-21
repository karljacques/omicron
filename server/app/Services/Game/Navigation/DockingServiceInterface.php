<?php


namespace App\Services\Game\Navigation;


use App\Dockable;
use App\Ship;

interface DockingServiceInterface
{
    public function dock(Ship $ship, Dockable $dockable) : bool;
    public function undock(Ship $ship) : bool;
}
