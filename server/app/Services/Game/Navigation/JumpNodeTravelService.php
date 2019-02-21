<?php

namespace App\Services\Game\Navigation;


use App\JumpNode;
use App\Ship;

class JumpNodeTravelService implements JumpNodeTravelServiceInterface
{

    public function jump(Ship $ship, JumpNode $node): bool
    {
        if (!$this->isEligibleToJump($ship, $node))
            return false;

        // Execute the jump
        $ship->position_x = $node->destination_x;
        $ship->position_y = $node->destination_y;
        $ship->system_id  = $node->destination_system_id;

        $ship->save();
        return true;
    }

    protected function isEligibleToJump(Ship $ship, JumpNode $jump_node): bool
    {
        if ($ship->docked_at !== null)
            return false;

        if (!$jump_node->getSourcePosition()->equal($ship->getPosition()))
            return false;

        return true;
    }
}
