<?php

namespace App\Http\Controllers;


use App\Character;
use App\JumpNode;
use App\Planet;
use App\Ship;
use App\Station;
use App\System;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InitialisationController extends Controller
{
    public function initialState(Character $character) {
        // Current user
        $ship = $character->ship;

        // Get system
        //$system = System::find($ship->system_id);
        $system = clone $ship->system;
        $system->sectors;

        $jump_nodes = JumpNode::where('source_system_id', $system->id)->get();
        $stations = Station::where('system_id', $system->id)->get();
        $planets = Planet::where('system_id', $system->id)->get();

        return response()->json([
            'ship' => $ship,
            'system' => $system,
            'jump_nodes' => $jump_nodes,
            'planets' => $planets,
            'stations' => $stations
        ]);
    }
}
