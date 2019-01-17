<?php

namespace App\Http\Controllers;

use App\JumpNode;
use App\Sector;
use App\System;
use App\Vector2;
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
        $node_vector = $jump_node->getSourcePositionVector3();
        $ship_position_vector = $user->ship->getPositionVector3();

        if ($node_vector->equal($ship_position_vector)) {
            // Execute the jump
            $user->ship->position_x = $jump_node->destination_x;
            $user->ship->position_y = $jump_node->destination_y;
            $user->ship->system_id = $jump_node->destination_system_id;

            $user->ship->save();

            return response()->json([
                'success' => true,
                'ship' => $user->ship,
                'system' => System::find($user->ship->system_id),
                'nodes' => JumpNode::where('source_system_id', $user->ship->system_id)->get()]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'You are not in the source position of this jump node'
            ]);
        }
    }

    public function move(Request $request)
    {
        $user = Auth::user();

        $ship = $user->ship;

        $delta = new Vector2($request->only('x', 'y'));;

        if ($delta->length() === 1) {

            // Original position
            $original_position = $ship->getPositionVector2();

            // Execute
            $ship->position_x += $delta->x;
            $ship->position_y += $delta->y;

            if ($ship->position_x <= $ship->system->size_x &&
                $ship->position_y <= $ship->system->size_y &&
                $ship->position_x > 0 &&
                $ship->position_y > 0) {

                // Get the current sector and calculate fuel consumption
                $current_sector = Sector::where('system_id', $ship->system_id)
                    ->where('x', $original_position->x)
                    ->where('y', $original_position->y)->first();

                $move_cost = $current_sector->sector_type_id ?? 1;
                // Cost is equal to sector_type_id to start with
                $ship->fuel -= $move_cost;

                $ship->save();
            } else {
                return response()->json(['success' => false, 'You cannot move to a position outside of system bounds']);
            }


            return response()->json(['ship' => $ship, 'success' => true]);
        } else {
            return response()->json(['error' => 'You cannot move to this position', 'success' => false]);
        }
    }
}
