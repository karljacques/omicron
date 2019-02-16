<?php

namespace App\Http\Controllers;

use App\Position;
use App\Repositories\ShipRepository;
use App\Ship;
use App\Station;
use App\Planet;
use App\JumpNode;
use App\Sector;
use App\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function jump(JumpNode $jump_node)
    {
        $user = Auth::user();

        // Is the user in the same sector as the JumpNode?
        $node_position          = $jump_node->getSourcePosition();
        $ship_position_vector = $user->ship->getPosition();

        if ($node_position->equal($ship_position_vector)) {
            // Execute the jump
            $user->ship->position_x = $jump_node->destination_x;
            $user->ship->position_y = $jump_node->destination_y;
            $user->ship->system_id  = $jump_node->destination_system_id;

            $user->ship->save();

            $system = System::find($user->ship->system_id);
            $system->load('sectors');

            $stations = Station::where('system_id', $system->id)->get();
            $planets  = Planet::where('system_id', $system->id)->get();


            // Get ships in sector
            $ships_in_sector = Ship::where(
                [
                    'system_id'  => $system->id,
                    'position_x' => $user->ship->position_x,
                    'position_y' => $user->ship->position_y
                ])
                                   ->where([['id', '!=', $user->ship->id]])
                                   ->get();

            return response()->json(
                [
                    'success'         => true,
                    'ship'            => $user->ship,
                    'system'          => $system,
                    'jump_nodes'      => JumpNode::where('source_system_id', $user->ship->system_id)->get(),
                    'planets'         => $planets,
                    'stations'        => $stations,
                    'ships_in_sector' => $ships_in_sector
                ]);
        } else {
            return response()->json([
                                        'success' => false,
                                        'error'   => 'You are not in the source position of this jump node'
                                    ]);
        }
    }

    public function move(Request $request, ShipRepository $ship_repository)
    {
        $user = Auth::user();

        /** @var Ship $ship */
        $ship = $user->ship;

        $delta = Position::fromArray($request->only('x', 'y'));;

        if ($delta->length() === 1) {

            // Original position
            $original_position = $ship->getPosition();

            // Execute
            $ship->position_x += $delta->getX();
            $ship->position_y += $delta->getY();

            if ($ship->position_x <= $ship->system->size_x &&
                $ship->position_y <= $ship->system->size_y &&
                $ship->position_x > 0 &&
                $ship->position_y > 0) {

                // Get the current sector and calculate fuel consumption
                $current_sector = Sector::where('system_id', $ship->system_id)
                                        ->where('x', $original_position->getX())
                                        ->where('y', $original_position->getY())->first();

                $move_cost = $current_sector->sector_type_id ?? 1;
                // Cost is equal to sector_type_id to start with
                $ship->fuel -= $move_cost;

                $ship->save();
            } else {
                return response()->json(['success' => false, 'You cannot move to a position outside of system bounds']);
            }

            $ships_in_sector = $ship_repository->getShipsInSector($ship->getPosition());

            return response()->json(['ship' => $ship, 'success' => true, 'ships_in_sector' => $ships_in_sector]);
        } else {
            return response()->json(['error' => 'You cannot move to this position', 'success' => false]);
        }
    }
}
