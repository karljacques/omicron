<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class ShipType extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];
}
