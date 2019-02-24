<?php

namespace App\Providers;

use App\Services\Game\Character\FinanceService;
use App\Services\Game\Character\FinanceServiceInterface;
use App\Services\Game\Marketplace\TradingService;
use App\Services\Game\Marketplace\TradingServiceInterface;
use App\Services\Game\Navigation\DockingService;
use App\Services\Game\Navigation\DockingServiceInterface;
use App\Services\Game\Navigation\JumpNodeTravelService;
use App\Services\Game\Navigation\JumpNodeTravelServiceInterface;
use App\Services\Game\Navigation\PositionService;
use App\Services\Game\Navigation\PositionServiceInterface;
use App\Services\Game\Ship\CargoService;
use App\Services\Game\Ship\CargoServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        PositionServiceInterface::class       => PositionService::class,
        JumpNodeTravelServiceInterface::class => JumpNodeTravelService::class,
        DockingServiceInterface::class        => DockingService::class,

        TradingServiceInterface::class => TradingService::class,
        CargoServiceInterface::class   => CargoService::class,
        FinanceServiceInterface::class => FinanceService::class
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
