<?php

namespace App\Providers;

use App\Repositories\CargoRepository;
use App\Repositories\CargoRepositoryInterface;
use App\Repositories\CommoditiesRepository;
use App\Repositories\CommoditiesRepositoryInterface;
use App\Repositories\SectorRepositiory;
use App\Repositories\SectorRepositoryInterface;
use App\Repositories\ShipRepository;
use App\Repositories\ShipRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        ShipRepositoryInterface::class   => ShipRepository::class,
        SectorRepositoryInterface::class => SectorRepositiory::class,

        CommoditiesRepositoryInterface::class => CommoditiesRepository::class,
        CargoRepositoryInterface::class       => CargoRepository::class
    ];

    public function register()
    {

    }
}
