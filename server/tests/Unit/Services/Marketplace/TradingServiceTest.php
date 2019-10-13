<?php

namespace Tests\Unit\Services\Marketplace;

use App\Character;
use App\Commodity;
use App\Dockable;
use App\DockableCommodity;
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
        $character = new Character();
        $ship      = new Ship();
        $dockable  = new Dockable();

        $price    = 100;
        $quantity = 200;

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

    public function testSell()
    {

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
