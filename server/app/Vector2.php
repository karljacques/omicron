<?php

namespace App;

class Vector2
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

    public function equal(Vector2 $a) {
        return $a->x === $this->x && $a->y === $this->y;
    }

//    public static function createFromNode(JumpNode $node) {
//        return new Vector($node->source_x, $node->source_y);
//    }
}
