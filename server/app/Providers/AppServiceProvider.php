<?php

namespace App\Providers;

use App\Services\Game\Navigation\JumpNodeTravelService;
use App\Services\Game\Navigation\JumpNodeTravelServiceInterface;
use App\Services\Game\Navigation\PositionService;
use App\Services\Game\Navigation\PositionServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        PositionServiceInterface::class       => PositionService::class,
        JumpNodeTravelServiceInterface::class => JumpNodeTravelService::class
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
