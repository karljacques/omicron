<?php

namespace App;

class Station extends Dockable
{
    protected $table = 'stations';

    public function commodities()
    {
        return $this->belongsToMany(Commodity::class, 'dockable_commodities', 'dockable_id')
                    ->withPivot('stock', 'sell', 'buy');
    }
}
