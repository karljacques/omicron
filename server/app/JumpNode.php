<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed destination_x
 * @property mixed destination_y
 * @property mixed destination_system_id
 * @property mixed source_x
 * @property mixed source_y
 * @property mixed source_system_id
 */
class JumpNode extends Model
{
    public $timestamps = false;

    public function getSourcePosition(): Position
    {
        return new Position($this->source_x, $this->source_y, $this->source_system_id);
    }

}
