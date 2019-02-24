<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class DockableCommodity extends Model
{
    public function commodity() {
        return $this->belongsTo(Commodity::class);
    }
}
