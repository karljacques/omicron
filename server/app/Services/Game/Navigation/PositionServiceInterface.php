<?php

namespace App\Services\Game\Navigation;


use App\Position;
use App\Ship;

interface PositionServiceInterface
{
    public function move(Ship $ship, Position $delta) : bool;
}
