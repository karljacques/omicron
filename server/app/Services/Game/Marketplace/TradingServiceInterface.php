<?php

namespace App\Services\Game\Marketplace;


use App\Character;
use App\Commodity;
use App\Exceptions\UserActionException;

interface TradingServiceInterface
{
    /**
     * @param Character $character
     * @param Commodity $commodity
     * @param int       $quantity
     * @param int       $price
     *
     * @throws UserActionException
     */
    public function buy(Character $character, Commodity $commodity, int $quantity, int $price): void;

    /**
     * @param Character $character
     * @param Commodity $commodity
     * @param int       $quantity
     * @param int       $price
     *
     * @throws UserActionException
     */
    public function sell(Character $character, Commodity $commodity, int $quantity, int $price): void;
}
