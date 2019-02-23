<?php

namespace App\Http\Controllers\Game\Navigation;

use App\Http\Controllers\Controller;
use App\Position;
use App\Repositories\ShipRepository;
use App\Services\Game\Navigation\JumpNodeTravelServiceInterface;
use App\Services\Game\Navigation\PositionServiceInterface;
use App\Ship;
use App\Station;
use App\Planet;
use App\JumpNode;
use App\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    protected $ship_repository;

    public function __construct(ShipRepository $ship_repository)
    {
        $this->middleware('auth');
        $this->ship_repository = $ship_repository;
    }

    public function jump(JumpNode $jump_node, JumpNodeTravelServiceInterface $jump_node_travel_service)
    {
        $character = Auth::user()->character->first();
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

        return response()->json(
            [
                'success'         => true,
                'ship'            => $ship,
                'system'          => $system,
                'jump_nodes'      => JumpNode::where('source_system_id', $ship->system_id)->get(),
                'planets'         => $planets,
                'stations'        => $stations,
                'ships_in_sector' => $ships_in_sector
            ]);
    }

    function move(Request $request, PositionServiceInterface $position_service)
    {
        $user = Auth::user();

        /** @var Ship $ship */
        $character = Auth::user()->character->first();
        $ship = $character->ship;

        $delta = Position::fromArray($request->only('x', 'y'));;

        $move_success = $position_service->move($ship, $delta);

        if ($move_success) {
            $ships_in_sector = $this->ship_repository->getShipsInSector($ship->getPosition());
            return response()->json(['ship' => $ship, 'success' => true, 'ships_in_sector' => $ships_in_sector]);
        } else {
            return response()->json(['success' => false, 'Move unsuccessful']);
        }
    }
}
