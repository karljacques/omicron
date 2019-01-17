<?php

namespace App;

class Vector3
{
    public $x;
    public $y;
    public $z; // In this application, z will typically be used for system_id

    /**
     * Vector3 constructor.
     * @param int $x
     * @param int $y
     * @param int $z
     */
    public function __construct(int $x, int $y, int $z)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    // Manhattan distance - not likely to be hugely useful when it comes to this game
    public function length() {
        return abs($this->x) + abs($this->y) + abs($this->z);
    }

    public function equal(Vector3 $vector) {
        return $vector->x === $this->x && $vector->y === $this->y && $vector->z === $this->z;
    }

//    public static function createFromNode(JumpNode $node) {
//        return new Vector($node->source_x, $node->source_y);
//    }
}
