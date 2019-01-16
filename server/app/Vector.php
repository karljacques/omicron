<?php

namespace App;

class Vector
{
    public $x;
    public $y;

    public function __construct($x, $y = null)
    {
        // I really wish PHP had function overloading.
        if ($y) {
            $this->x = $x;
            $this->y = $y;
        } else {
            $this->x = $x['x'];
            $this->y = $x['y'];
        }
    }

    // Manhattan distance
    public function length() {
        return abs($this->x) + abs($this->y);
    }
}
