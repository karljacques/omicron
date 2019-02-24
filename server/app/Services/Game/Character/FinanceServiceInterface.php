<?php

namespace App\Services\Game\Character;


use App\Character;

interface FinanceServiceInterface
{
    public function charge(Character $character, int $money);

    public function credit(Character $character, int $money);

    public function canAfford(Character $character, int $money): bool ;
}
