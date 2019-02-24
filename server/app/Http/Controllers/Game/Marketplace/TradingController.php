<?php

namespace App\Http\Controllers\Game\Marketplace;


use App\Character;
use App\Commodity;
use App\Repositories\CommoditiesRepositoryInterface;
use App\Services\Game\Marketplace\TradingServiceInterface;
use Illuminate\Http\Request;

use App\Http\Resources\Character as CharacterResource;
use App\Http\Resources\Ship as ShipResource;

class TradingController
{
    protected $trading_service;

    public function __construct(TradingServiceInterface $trading_service)
    {
        $this->trading_service = $trading_service;
    }

    public function buy(Character $character, Request $request)
    {
        $commodity_id = $request->get('commodity_id');
        $quantity     = $request->get('quantity');
        $price        = $request->get('price');

        $ship = $character->ship;

        $success = $this->trading_service->buy($character, Commodity::find($commodity_id), $quantity, $price);

        return response()->json(
            [
                'success'   => $success,
                'character' => new CharacterResource($character),
                'ship'      => new ShipResource($ship)
            ]);


    }

    public function sell(Character $character, Request $request)
    {
        $commodity_id = $request->get('commodity_id');
        $quantity     = $request->get('quantity');
        $price        = $request->get('price');

        $ship = $character->ship;

        $success = $this->trading_service->sell($character, Commodity::find($commodity_id), $quantity, $price);

        return response()->json(
            [
                'success'   => $success,
                'character' => new CharacterResource($character),
                'ship'      => new ShipResource($ship)
            ]);


    }
}
