<?php

namespace App\Services\Game\Navigation;


use App\JumpNode;
use App\Ship;

interface JumpNodeTravelServiceInterface
{
    public function jump(Ship $ship, JumpNode $node): bool;
}
