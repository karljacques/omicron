<?php

namespace App\Providers;

use App\Repositories\ShipRepository;
use App\Repositories\ShipRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register () {
        $this->app->bind(
            ShipRepositoryInterface::class,
            ShipRepository::class
        );
    }
}
