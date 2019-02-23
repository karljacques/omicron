<?php

namespace App\Http\Controllers;

use App\Character;
use App\JumpNode;
use App\Planet;
use App\Repositories\ShipRepository;
use App\Station;

use App\Http\Resources\Ship as ShipResource;
use App\Http\Resources\System as SystemResource;
use App\Http\Resources\Station as StationResource;
use App\Http\Resources\Planet as PlanetResource;
use App\Http\Resources\JumpNode as JumpNodeResource;
use App\Http\Resources\Character as CharacterResource;

class InitialisationController extends Controller
{
    public function initialState(Character $character, ShipRepository $ship_repository)
    {
        // Current user
        $ship   = $character->ship;
        $system = $ship->system;

        $jump_nodes = JumpNode::where('source_system_id', $system->id)->get();
        $stations   = Station::where('system_id', $system->id)->get();
        $planets    = Planet::where('system_id', $system->id)->get();

        $ships_in_sector = $ship_repository->getShipsInSector($ship->getPosition());

        return response()->json(
            [
                'ship'            => new ShipResource($ship),
                'system'          => new SystemResource($system),
                'jump_nodes'      => JumpNodeResource::collection($jump_nodes),
                'planets'         => PlanetResource::collection($planets),
                'stations'        => StationResource::collection($stations),
                'ships_in_sector' => ShipResource::collection($ships_in_sector),
                'character'       => new CharacterResource($character)
            ]);
    }
}
