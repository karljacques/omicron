<?php

namespace App\Services\Game\Character;


use App\Character;

class FinanceService implements FinanceServiceInterface
{

    public function charge(Character $character, int $money)
    {
        // TODO: Implement charge() method.
        $character->money -= $money;
        $character->save();
    }

    public function credit(Character $character, int $money)
    {
        $character->money += $money;
        $character->save();
    }

    public function canAfford(Character $character, int $money): bool
    {
        return $character->money >= $money;
    }
}
