<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Ship ship
 */
class Character extends Model
{
    public function ship() {
        return $this->hasOne(Ship::class);
    }
}
