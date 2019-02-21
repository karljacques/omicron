<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

/**
* @property mixed position_x
* @property mixed position_y
* @property mixed system_id
 */
class Dockable extends Model
{
    public $timestamps = false;

    public function system() {
        return $this->belongsTo(System::class);
    }

    public function getPosition(): Position {
        return new Position($this->position_x, $this->position_y, $this->system_id);
    }
}
