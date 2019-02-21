<?php

namespace App;

/**
 * @property mixed system
 * @property mixed fuel
 * @property mixed docked_at
 */
class Ship extends Dockable
{
    protected $table = 'ships';
}
