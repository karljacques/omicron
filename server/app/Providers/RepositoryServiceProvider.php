<?php

namespace App\Providers;

use App\Repositories\SectorRepositiory;
use App\Repositories\SectorRepositoryInterface;
use App\Repositories\ShipRepository;
use App\Repositories\ShipRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        ShipRepositoryInterface::class => ShipRepository::class,
        SectorRepositoryInterface::class => SectorRepositiory::class
    ];

    public function register () {

    }
}
