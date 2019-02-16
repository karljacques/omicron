<?php
/**
 * Created by PhpStorm.
 * User: karlj
 * Date: 16/02/2019
 * Time: 14:51
 */

namespace App\Repositories;


use App\Position;
use App\Sector;

interface SectorRepositoryInterface
{
    public function getSectorAtPosition(Position $position) : ?Sector;
}
