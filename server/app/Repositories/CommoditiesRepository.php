<?php

namespace App\Repositories;


use App\Commodity;
use App\Dockable;
use App\DockableCommodity;
use Illuminate\Support\Collection;

class CommoditiesRepository implements CommoditiesRepositoryInterface
{

    /**
     * @param Dockable $dockable
     *
     * @return Collection
     */
    public function getCommoditiesSoldAtDockable(Dockable $dockable): Collection
    {
        return DockableCommodity::where('dockable_id', $dockable->id)->whereNotNull('sell')->get();
    }

    /**
     * @param Dockable $dockable
     *
     * @return Collection
     */
    public function getCommoditiesBoughtAtDockable(Dockable $dockable): Collection
    {
        return DockableCommodity::where('dockable_id', $dockable->id)->whereNotNull('buy')->get();
    }

    /**
     * @param Dockable  $dockable
     * @param Commodity $commodity
     *
     * @return DockableCommodity|null
     */
    public function getCommoditySoldAtDockable(Dockable $dockable, Commodity $commodity): ?DockableCommodity
    {
        return DockableCommodity::where('dockable_id', $dockable->id)->where('commodity_id', $commodity->id)->whereNotNull('sell')->get()->first();
    }

    /**
     * @param Dockable  $dockable
     * @param Commodity $commodity
     *
     * @return DockableCommodity|null
     */
    public function getCommodityBoughtAtDockable(Dockable $dockable, Commodity $commodity): ?DockableCommodity
    {
        return DockableCommodity::where('dockable_id', $dockable->id)->where('commodity_id', $commodity->id)->whereNotNull('buy')->get()->first();
    }
}
