<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Ship  ship
 * @property mixed money
 */
class Character extends Model
{
    public function ship() {
        return $this->hasOne(Ship::class);
    }
}
