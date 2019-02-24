<?php

namespace App\Services\Game\Marketplace;


use App\Character;
use App\Commodity;

interface TradingServiceInterface
{
    public function buy(Character $character, Commodity $commodity, int $quantity, int $price);
}
