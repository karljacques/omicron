<?php

namespace App;

/**
 * @property mixed system
 * @property mixed fuel
 * @property mixed docked_at
 * @property mixed max_fuel
 * @property mixed dockedAt
 */
class Ship extends Dockable
{
    protected $table = 'ships';

    public function dockedAt()
    {
        return $this->belongsTo(Dockable::class, 'docked_at');
    }

    public function cargo()
    {
        return $this->belongsToMany(Commodity::class, 'ship_cargo');
    }
}
