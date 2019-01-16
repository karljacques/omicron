<?php

namespace App\Http\Controllers;


use App\Ship;
use App\System;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InitialisationController extends Controller
{
    public function initialState() {
        // Current user
        $user = Auth::user();

        // Get ship
        $ship = $user->ship;

        // Get system
        //$system = System::find($ship->system_id);
        $system = clone $ship->system;
        $system->sectors;


        return response()->json([
            'ship' => $ship,
            'system' => $system
//            'system' => $system
        ]);
    }
}
