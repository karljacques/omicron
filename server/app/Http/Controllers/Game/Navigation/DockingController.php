<?php


namespace App\Http\Controllers\Game\Navigation;

use App\Http\Controllers\Controller;
use App\Dockable;
use App\Services\Game\Navigation\DockingServiceInterface;
use Illuminate\Auth\AuthManager;

class DockingController extends Controller
{
    protected $docking_service;
    protected $auth_manager;

    public function __construct(DockingServiceInterface $docking_service, AuthManager $auth_manager)
    {
        $this->docking_service = $docking_service;
        $this->auth_manager    = $auth_manager;
    }

    public function dock(Dockable $dockable)
    {
        $user = $this->auth_manager->user();
        $ship = $user->ship;

        $success = $this->docking_service->dock($ship, $dockable);

        return response()->json(
            [
                'success' => $success
            ]);
    }

    public function undock()
    {
        $user = $this->auth_manager->user();
        $ship = $user->ship;

        $success = $this->docking_service->undock($ship);

        return response()->json(
            [
                'success' => $success
            ]);
    }
}
