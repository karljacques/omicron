<?php
/**
 * Created by PhpStorm.
 * User: karlj
 * Date: 16/02/2019
 * Time: 14:59
 */

namespace App\Services\Game\Navigation;


use App\JumpNode;
use App\Ship;

class JumpNodeTravelService implements JumpNodeTravelServiceInterface
{

    public function jump(Ship $ship, JumpNode $node): bool
    {
        if ($node->getSourcePosition()->equal($ship->getPosition())) {
            // Execute the jump
            $ship->position_x = $node->destination_x;
            $ship->position_y = $node->destination_y;
            $ship->system_id  = $node->destination_system_id;

            $ship->save();
            return true;
        }

        return false;
    }
}
