<?php
/**
 * Created by PhpStorm.
 * User: karlj
 * Date: 16/02/2019
 * Time: 14:52
 */

namespace App\Repositories;


use App\Position;
use App\Sector;

class SectorRepositiory implements SectorRepositoryInterface
{

    public function getSectorAtPosition(Position $position): ?Sector
    {
        return Sector::where('system_id', $position->getSystemId())
                                ->where('x', $position->getX())
                                ->where('y', $position->getY())->first();
    }
}
