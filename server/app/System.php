<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed size_x
 * @property mixed size_y
 */
class System extends Model
{
    public $timestamps = false;

    public function sectors() {
        return $this->hasMany(Sector::class);
    }
}
