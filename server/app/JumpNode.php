<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JumpNode extends Model
{
    public $timestamps = false;

    public function getSourcePositionVector2(): Vector2
    {
        return new Vector2($this->source_x, $this->source_y);
    }

    public function getSourcePositionVector3(): Vector3
    {
        return new Vector3($this->source_x, $this->source_y, $this->source_system_id);
    }
}
