<?php

namespace Tests\Unit\Services\Ship;

use App\Repositories\CargoRepositoryInterface;
use App\Services\Game\Ship\CargoService;
use App\Services\Game\Ship\CargoServiceInterface;
use App\Ship;
use App\Storable;
use Mockery;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;

class CargoServiceTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /** @var Mock */
    protected $cargo_repository;

    /** @var CargoServiceInterface */
    protected $cargo_service;

    public function setUp()
    {
        $this->cargo_repository = Mockery::mock(CargoRepositoryInterface::class);

        $this->cargo_service = new CargoService($this->cargo_repository);
    }

    public function testAddStorableToCargoEmptyShip()
    {
        $quantity = 50;

        // Make ship a partial mock so that it can keep all of it's attributes but I can
        // call save without it trying to hit a real database
        $ship = Mockery::mock(Ship::class)->makePartial();
        $ship->shouldReceive('save')->once();

        $ship->cargo     = 0;
        $ship->max_cargo = 100;

        $storable = new Storable();

        $storable->id         = CargoService::NOT_FUEL;
        $storable->cargo_size = 2;

        $this->cargo_repository->shouldReceive('getStorableQuantity')
                               ->with($ship, $storable)
                               ->andReturn(0);

        $this->cargo_repository->shouldReceive('setStorableQuantity')
                               ->with($ship, $storable, $quantity);

        $this->cargo_repository->shouldReceive('calculateShipCargoUsage')
                               ->with($ship)
                               ->andReturn($quantity * $storable->cargo_size);

        $this->cargo_service->addStorableToCargo($ship, $storable, $quantity);

        $this->assertEquals($quantity * $storable->cargo_size, $ship->cargo);
    }
}
