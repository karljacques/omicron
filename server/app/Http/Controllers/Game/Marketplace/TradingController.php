<?php

namespace App\Http\Controllers\Game\Marketplace;


use App\Character;
use App\Commodity;
use App\Exceptions\UserActionException;
use App\Repositories\CommoditiesRepositoryInterface;
use App\Services\Game\Marketplace\TradingServiceInterface;
use Illuminate\Http\Request;

use App\Http\Resources\Character as CharacterResource;
use App\Http\Resources\Ship as ShipResource;

class TradingController
{
    protected $trading_service;

    /**
     * TradingController constructor.
     *
     * @param TradingServiceInterface $trading_service
     */
    public function __construct(TradingServiceInterface $trading_service)
    {
        $this->trading_service = $trading_service;
    }

    /**
     * @param Character $character
     * @param Request   $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function buy(Character $character, Request $request)
    {
        $commodity_id = $request->get('commodity_id');
        $quantity     = $request->get('quantity');
        $price        = $request->get('price');

        $ship = $character->ship;

        try {
            $this->trading_service->buy($character, Commodity::find($commodity_id), $quantity, $price);
        } catch (UserActionException $e) {
            return response()->json(
                [
                    'success' => false,
                    'error'   => $e->getMessage()
                ]
            );
        }

        return response()->json(
            [
                'success'   => true,
                'character' => new CharacterResource($character),
                'ship'      => new ShipResource($ship)
            ]);


    }

    /**
     * @param Character $character
     * @param Request   $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sell(Character $character, Request $request)
    {
        $commodity_id = $request->get('commodity_id');
        $quantity     = $request->get('quantity');
        $price        = $request->get('price');

        $ship = $character->ship;

        try {
            $this->trading_service->sell($character, Commodity::find($commodity_id), $quantity, $price);
        } catch (UserActionException $e) {
            return response()->json(
                [
                    'success' => false,
                    'error'   => $e->getMessage()
                ]
            );
        }

        return response()->json(
            [
                'success'   => true,
                'character' => new CharacterResource($character),
                'ship'      => new ShipResource($ship)
            ]);


    }
}
