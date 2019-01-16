<?php

namespace App\Http\Controllers;

use App\Sector;
use App\Vector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function move(Request $request)
    {
        $user = Auth::user();

        $ship = $user->ship;

        $delta = new Vector($request->only('x', 'y'));;

        if ($delta->length() === 1) {

            // Original position
            $original_position = new Vector($ship->position_x, $ship->position_y);

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
