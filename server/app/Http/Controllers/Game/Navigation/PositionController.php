<?php

namespace App\Http\Controllers;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


}
