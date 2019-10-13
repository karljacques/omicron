<?php

namespace Tests\Unit\Services\Marketplace;

use App\Character;
use App\Commodity;
use App\Dockable;
use App\DockableCommodity;
use App\Exceptions\UserActionException;
use App\Repositories\CommoditiesRepositoryInterface;
use App\Services\Game\Character\FinanceServiceInterface;
use App\Services\Game\Marketplace\TradingService;
use App\Services\Game\Ship\CargoServiceInterface;
use App\Ship;
use Mockery;
use PHPUnit\Framework\TestCase;

class TradingServiceTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /** @var Mockery\Mock */
    protected $commodities_repository;
    /** @var Mockery\Mock */
    protected $finance_service;
    /** @var Mockery\Mock */
    protected $cargo_service;

    /** @var TradingService */
    protected $trading_service;

    public function setUp()
    {
        parent::setUp();

        $this->commodities_repository = Mockery::mock(CommoditiesRepositoryInterface::class);
        $this->finance_service        = Mockery::mock(FinanceServiceInterface::class);
        $this->cargo_service          = Mockery::mock(CargoServiceInterface::class);

        $this->trading_service = new TradingService($this->commodities_repository,
                                                    $this->finance_service,
                                                    $this->cargo_service);
    }

    public function testBuy()
    {

        $price    = 100;
        $quantity = 200;

        $character = new Character();
        $ship      = new Ship();
        $dockable  = new Dockable();

        $character->setRelation('ship', $ship);
        $ship->setRelation('dockedAt', $dockable);

        $commodity          = new Commodity();
        $dockable_commodity = new DockableCommodity();

        $dockable_commodity->sell = $price;

        $this->commodities_repository->shouldReceive('getCommoditySoldAtDockable')
                                     ->once()
                                     ->with($dockable, $commodity)
                                     ->andReturn($dockable_commodity);

        $this->finance_service->shouldReceive('canAfford')
                              ->once()
                              ->with($character, $price * $quantity)
                              ->andReturn(true);

        $this->finance_service->shouldReceive('charge')
                              ->once()
                              ->with($character, $price * $quantity);

        $this->cargo_service->shouldReceive('addStorableToCargo')
                            ->once()
                            ->with($ship, $commodity, $quantity);

        $this->trading_service->buy($character, $commodity, $quantity, $price);
    }

    public function testBuyZeroQuantity()
    {
        $this->expectException(UserActionException::class);

        $this->cargo_service->shouldNotReceive('addStorableToCargo');
        $this->finance_service->shouldNotReceive('charge');

        $this->trading_service->buy(new Character(), new Commodity(), 0, 1);
    }

    public function testBuyMinusQuantity()
    {
        $this->expectException(UserActionException::class);

        $this->cargo_service->shouldNotReceive('addStorableToCargo');
        $this->finance_service->shouldNotReceive('charge');

        $this->trading_service->buy(new Character(), new Commodity(), -1, 1);
    }

    public function testBuyWhenNotDocked()
    {
        $character = new Character();
        $ship      = new Ship();

        $character->setRelation('ship', $ship);
        $ship->setRelation('dockedAt', null);

        $this->expectException(UserActionException::class);

        $this->cargo_service->shouldNotReceive('addStorableToCargo');
        $this->finance_service->shouldNotReceive('charge');

        $this->trading_service->buy($character, new Commodity(), 1, 1);
    }

    public function testBuyingItemNotSoldAtDockable()
    {
        $character = new Character();
        $ship      = new Ship();
        $dockable  = new Dockable();

        $character->setRelation('ship', $ship);
        $ship->setRelation('dockedAt', $dockable);

        $commodity = new Commodity();

        $this->expectException(UserActionException::class);

        $this->commodities_repository->shouldReceive('getCommoditySoldAtDockable')
                                     ->once()
                                     ->with($dockable, $commodity)
                                     ->andReturn(null);

        $this->cargo_service->shouldNotReceive('addStorableToCargo');
        $this->finance_service->shouldNotReceive('charge');

        $this->trading_service->buy($character, $commodity, 1, 1);
    }

    public function testBuyPriceMismatchBetweenClientAndServer()
    {
        $price = 100;

        $character = new Character();
        $ship      = new Ship();
        $dockable  = new Dockable();

        $character->setRelation('ship', $ship);
        $ship->setRelation('dockedAt', $dockable);

        $commodity                = new Commodity();
        $dockable_commodity       = new DockableCommodity();
        $dockable_commodity->sell = $price;

        $this->expectException(UserActionException::class);

        $this->commodities_repository->shouldReceive('getCommoditySoldAtDockable')
                                     ->once()
                                     ->with($dockable, $commodity)
                                     ->andReturn($dockable_commodity);

        $this->cargo_service->shouldNotReceive('addStorableToCargo');
        $this->finance_service->shouldNotReceive('charge');

        $this->trading_service->buy($character, $commodity, 1, $price + 1);
    }

    public function testCharacterCannotAffordToBuy()
    {
        $price    = 100;
        $quantity = 50;

        $character = new Character();
        $ship      = new Ship();
        $dockable  = new Dockable();

        $character->setRelation('ship', $ship);
        $ship->setRelation('dockedAt', $dockable);

        $commodity                = new Commodity();
        $dockable_commodity       = new DockableCommodity();
        $dockable_commodity->sell = $price;

        $this->expectException(UserActionException::class);

        $this->commodities_repository->shouldReceive('getCommoditySoldAtDockable')
                                     ->once()
                                     ->with($dockable, $commodity)
                                     ->andReturn($dockable_commodity);

        $this->finance_service->shouldReceive('canAfford')
                              ->once()
                              ->with($character, $price * $quantity)
                              ->andReturn(false);

        $this->cargo_service->shouldNotReceive('addStorableToCargo');
        $this->finance_service->shouldNotReceive('charge');

        $this->trading_service->buy($character, $commodity, $quantity, $price);
    }


    public function testSell()
    {
        $price    = 100;
        $quantity = 50;

        $character = new Character();
        $ship      = new Ship();
        $dockable  = new Dockable();

        $character->setRelation('ship', $ship);
        $ship->setRelation('dockedAt', $dockable);

        $commodity          = new Commodity();
        $dockable_commodity = new DockableCommodity();

        $dockable_commodity->buy = $price;

        $this->commodities_repository->shouldReceive('getCommodityBoughtAtDockable')
                                     ->once()
                                     ->with($dockable, $commodity)
                                     ->andReturn($dockable_commodity);

        $this->cargo_service->shouldReceive('removeStorableFromCargo')
                            ->once()
                            ->with($ship, $commodity, $quantity)
                            ->andReturn(true);

        $this->finance_service->shouldReceive('credit')
                              ->once()
                              ->with($character, $price * $quantity);

        $this->trading_service->sell($character, $commodity, $quantity, $price);

    }

    public function testSellWithZeroQuantity()
    {
        $this->expectException(UserActionException::class);

        $this->finance_service->shouldNotReceive('credit');

        $this->trading_service->sell(new Character(), new Commodity(), 0, 1);
    }

    public function testSellWithMinusQuantity()
    {
        $this->expectException(UserActionException::class);

        $this->finance_service->shouldNotReceive('credit');

        $this->trading_service->sell(new Character(), new Commodity(), -1, 1);
    }

    public function testSellWhenNotDocked()
    {
        $character = new Character();
        $ship      = new Ship();

        $character->setRelation('ship', $ship);
        $ship->setRelation('dockedAt', null);

        $this->finance_service->shouldNotReceive('credit');

        $this->expectException(UserActionException::class);
        $this->trading_service->sell($character, new Commodity(), -1, 1);
    }

    public function testItemNotBoughtBuyDockable()
    {
        $character = new Character();
        $ship      = new Ship();
        $dockable  = new Dockable();

        $character->setRelation('ship', $ship);
        $ship->setRelation('dockedAt', $dockable);

        $commodity = new Commodity();

        $this->commodities_repository->shouldReceive('getCommodityBoughtAtDockable')
                                     ->once()
                                     ->with($dockable, $commodity)
                                     ->andReturn(null);

        $this->expectException(UserActionException::class);
        $this->finance_service->shouldNotReceive('credit');

        $this->trading_service->sell($character, $commodity, 1, 1);
    }

    public function testSellPriceMismatchBetweenClientAndServer()
    {
        $price = 100;

        $character = new Character();
        $ship      = new Ship();
        $dockable  = new Dockable();

        $character->setRelation('ship', $ship);
        $ship->setRelation('dockedAt', $dockable);

        $commodity               = new Commodity();
        $dockable_commodity      = new DockableCommodity();
        $dockable_commodity->buy = $price;

        $this->expectException(UserActionException::class);

        $this->commodities_repository->shouldReceive('getCommodityBoughtAtDockable')
                                     ->once()
                                     ->with($dockable, $commodity)
                                     ->andReturn($dockable_commodity);

        $this->finance_service->shouldNotReceive('credit');

        $this->trading_service->sell($character, $commodity, 1, $price + 1);
    }

    public function testSellUserDoesNotOwnCargo()
    {
        $price    = 100;
        $quantity = 50;

        $character = new Character();
        $ship      = new Ship();
        $dockable  = new Dockable();

        $character->setRelation('ship', $ship);
        $ship->setRelation('dockedAt', $dockable);

        $commodity               = new Commodity();
        $dockable_commodity      = new DockableCommodity();
        $dockable_commodity->buy = $price;

        $this->expectException(UserActionException::class);

        $this->commodities_repository->shouldReceive('getCommodityBoughtAtDockable')
                                     ->once()
                                     ->with($dockable, $commodity)
                                     ->andReturn($dockable_commodity);

        $this->cargo_service->shouldReceive('removeStorableFromCargo')
                            ->once()
                            ->with($ship, $commodity, $quantity)
                            ->andReturn(false);

        $this->finance_service->shouldNotReceive('credit');

        $this->trading_service->sell($character, $commodity, $quantity, $price);
    }


    public function tearDown()
    {
        parent::tearDown();

        $this->commodities_repository = null;
        $this->finance_service        = null;
        $this->cargo_service          = null;

        $this->trading_service = null;
    }
}
