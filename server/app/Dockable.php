<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int   id
 * @property int position_x
 * @property int position_y
 * @property int system_id
 */
class Dockable extends Model
{
    public $timestamps = false;

    public function system()
    {
        return $this->belongsTo(System::class);
    }

    public function getPosition(): Position
    {
        return new Position($this->position_x, $this->position_y, $this->system_id);
    }
}
