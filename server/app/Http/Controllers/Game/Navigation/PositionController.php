<?php

namespace App\Http\Controllers\Game\Navigation;

use App\Character;
use App\Exceptions\UserActionException;
use App\Http\Controllers\Controller;
use App\Position;
use App\Repositories\ShipRepository;
use App\Services\Game\Navigation\JumpNodeTravelServiceInterface;
use App\Services\Game\Navigation\PositionServiceInterface;

use App\Station;
use App\Planet;
use App\JumpNode;
use App\System;
use Illuminate\Http\Request;

use App\Http\Resources\Ship as ShipResource;
use App\Http\Resources\System as SystemResource;
use App\Http\Resources\JumpNode as JumpNodeResource;
use App\Http\Resources\Planet as PlanetResource;
use App\Http\Resources\Station as StationResource;

class PositionController extends Controller
{
    protected $ship_repository;

    public function __construct(ShipRepository $ship_repository)
    {
        $this->middleware('auth');
        $this->ship_repository = $ship_repository;
    }

    public function jump(JumpNode $jump_node, Character $character,
                         JumpNodeTravelServiceInterface $jump_node_travel_service)
    {
        $ship = $character->ship;

        $jump_success = $jump_node_travel_service->jump($ship, $jump_node);

        if (!$jump_success) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to jump'
                ]);
        }

        $system = System::find($ship->system_id);
        $system->load('sectors');

        $stations = Station::where('system_id', $system->id)->get();
        $planets  = Planet::where('system_id', $system->id)->get();

        // Get ships in sector
        $ships_in_sector = $this->ship_repository->getShipsInSector($ship->getPosition());

        $jump_nodes = JumpNode::where('source_system_id', $ship->system_id)->get();

        return response()->json(
            [
                'success'         => true,
                'ship'            => new ShipResource($ship),
                'system'          => new SystemResource($system),
                'jump_nodes'      => JumpNodeResource::collection($jump_nodes),
                'planets'         => PlanetResource::collection($planets),
                'stations'        => StationResource::collection($stations),
                'ships_in_sector' => ShipResource::collection($ships_in_sector)
            ]);
    }

    function move(Request $request, Character $character, PositionServiceInterface $position_service)
    {
        $ship = $character->ship;

        $delta = Position::fromArray($request->only('x', 'y'));;

        try {
            $move_success = $position_service->move($ship, $delta);
        } catch (UserActionException $e) {
            return response()->json($e->getJsonResponse());
        }

        if ($move_success) {
            $ships_in_sector = $this->ship_repository->getShipsInSector($ship->getPosition());
            return response()->json(
                [
                    'ship'            => new ShipResource($ship),
                    'success'         => true,
                    'ships_in_sector' => ShipResource::collection($ships_in_sector)
                ]);
        } else {
            return response()->json(['success' => false, 'Move unsuccessful']);
        }
    }
}
