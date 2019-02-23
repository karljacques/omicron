<?php


namespace App\Http\Controllers\Game\Navigation;

use App\Character;
use App\Http\Controllers\Controller;
use App\Dockable;
use App\Services\Game\Navigation\DockingServiceInterface;


use App\Http\Resources\Dockable as DockableResource;

class DockingController extends Controller
{
    protected $docking_service;

    public function __construct(DockingServiceInterface $docking_service)
    {
        $this->docking_service = $docking_service;
    }

    public function dock(Dockable $dockable, Character $character)
    {
        $ship = $character->ship;

        $success = $this->docking_service->dock($ship, $dockable);

        return response()->json(
            [
                'success' => $success,
                'dockable' => new DockableResource($dockable)
            ]);
    }

    public function undock(Character $character)
    {
        $ship = $character->ship;

        $success = $this->docking_service->undock($ship);

        return response()->json(
            [
                'success' => $success
            ]);
    }
}
