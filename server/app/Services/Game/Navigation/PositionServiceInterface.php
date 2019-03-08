<?php

namespace App\Services\Game\Navigation;


use App\Exceptions\UserActionException;
use App\Position;
use App\Ship;


interface PositionServiceInterface
{
    /**
     * @throws UserActionException
     */
    public function move(Ship $ship, Position $delta) : bool;
}
