<?php

namespace App\Http\Controllers\Game\Marketplace;


use App\Dockable;
use App\Repositories\CommoditiesRepositoryInterface;

use App\Http\Resources\DockableCommodity as DockableCommodityResource;

class MarketController
{
    public function get(Dockable $dockable,
                        CommoditiesRepositoryInterface $commodities_repository)
    {
        $commodities_sold   = $commodities_repository->getCommoditiesSoldAtDockable($dockable);
        $commodities_bought = $commodities_repository->getCommoditiesBoughtAtDockable($dockable);

        return response()->json(
            [
                'success'            => true,
                'commodities_sold'   => DockableCommodityResource::collection($commodities_sold),
                'commodities_bought' => DockableCommodityResource::collection($commodities_bought),
            ]);
    }
}
