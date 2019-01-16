<?php

namespace App\Http\Controllers;

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

        $delta = $request->only('x', 'y');
        $displacement = abs($delta['x'] + $delta['y']);

        if ($displacement === 1) {
            // Execute
            $ship->position_x += $delta['x'];
            $ship->position_y += $delta['y'];

            if ($ship->position_x <= $ship->system->size_x &&
                $ship->position_y <= $ship->system->size_y &&
                $ship->position_x > 0 &&
                $ship->position_y > 0) {
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
