<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    public $timestamps = false;

    public function system() {
        return $this->belongsTo(System::class);
    }

    public function getPosition(): Position {
        return new Position($this->position_x, $this->position_y, $this->system_id);
    }
}
