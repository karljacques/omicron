<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JumpNode extends Model
{
    public $timestamps = false;

    public function getSourcePosition(): Position
    {
        return new Position($this->source_x, $this->source_y, $this->source_system_id);
    }

}
