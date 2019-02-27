<?php

namespace App\Repositories;


use App\Ship;
use App\Storable;

interface CargoRepositoryInterface
{
    public function setStorableQuantity(Ship $ship, Storable $storable, int $quantity);
    public function getStorableQuantity(Ship $ship, Storable $storable): int;
}
