<?php

namespace App;

class Position
{
    protected $x;
    protected $y;
    protected $system_id;

    public static function fromArray($arr) {
        return new self($arr['x'], $arr['y'], $arr['system_id'] ?? null);
    }

    public function __construct(int $x, int $y, int $system_id = null)
    {
        $this->x = $x;
        $this->y = $y;

        $this->system_id = $system_id;
    }

    // Manhattan distance
    public function length()
    {
        return abs($this->x) + abs($this->y);
    }

    public function equal(Position $a)
    {
        if ($this->system_id) {
            return $a->getSystemId() == $this->system_id
                && $this->x === $a->getX()
                && $this->y === $a->getY();
        } else {
            return $a->x === $this->x && $a->y === $this->y;
        }

    }

    /**
     * @return mixed
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return mixed
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @return mixed
     */
    public function getSystemId(): ?int
    {
        return $this->system_id;
    }


}
