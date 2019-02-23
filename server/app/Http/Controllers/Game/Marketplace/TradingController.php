<?php

namespace App\Http\Controllers\Game\Marketplace;


use App\Character;
use Illuminate\Http\Request;

use App\Http\Resources\Character as CharacterResource;
use App\Http\Resources\Ship as ShipResource;

class TradingController
{
    public function buy(Character $character, Request $request)
    {
        // Fixed pricing for now
        $data = [
            1 => 2500,
            2 => 3200,
            3 => 7800
        ];

        $commodity_id = $request->get('commodity_id');
        $quantity     = $request->get('quantity');

        $ship = $character->ship;

        if ($commodity_id === 1) {
            $space_in_tank = $ship->max_fuel - $ship->fuel;
            if ($quantity > $space_in_tank) {
                $quantity = $space_in_tank;
            }
        }

        $unit_cost  = $data[$commodity_id];
        $total_cost = $unit_cost * $quantity;

        if (!($character->money >= $total_cost)) {
            return response()->json(['success' => false]);
        }

        if ($commodity_id === 1) {
            $ship->fuel += $quantity;
            $ship->save();
        }

        $character->money -= $total_cost;
        $character->save();

        return response()->json(
            [
                'success'   => true,
                'character' => new CharacterResource($character),
                'ship'      => new ShipResource($ship)
            ]);


    }
}
