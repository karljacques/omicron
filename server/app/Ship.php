<?php

namespace App;

/**
 * @property mixed system
 * @property mixed fuel
 * @property mixed docked_at
 * @property mixed max_fuel
 * @property mixed dockedAt
 * @property mixed cargo
 * @property mixed max_cargo
 * @property mixed power
 */
class Ship extends Dockable
{
    protected $table = 'ships';

    public function dockedAt()
    {
        return $this->belongsTo(Dockable::class, 'docked_at');
    }

    public function storables()
    {
        return $this->belongsToMany(Commodity::class, 'ship_cargo')->withPivot('quantity');
    }
}
