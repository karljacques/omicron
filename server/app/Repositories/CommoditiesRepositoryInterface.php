<?php

namespace App\Repositories;

use App\Commodity;
use App\Dockable;
use App\DockableCommodity;
use Illuminate\Support\Collection;

interface CommoditiesRepositoryInterface
{
    public function getCommoditiesSoldAtDockable(Dockable $dockable): Collection;
    public function getCommoditiesBoughtAtDockable(Dockable $dockable): Collection;

    public function getCommoditySoldAtDockable(Dockable $dockable, Commodity $commodity): ?DockableCommodity;
    public function getCommodityBoughtAtDockable(Dockable $dockable, Commodity $commodity): ?DockableCommodity;
}
