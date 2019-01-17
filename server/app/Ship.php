<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    public $timestamps = false;

    public function system() {
        return $this->belongsTo(System::class);
    }

    public function getPositionVector2(): Vector2 {
        return new Vector2($this->position_x, $this->position_y);
    }

    public function getPositionVector3(): Vector3 {
        return new Vector3($this->position_x, $this->position_y, $this->system_id);
    }
}
