<?php
use Illuminate\Database\Seeder;

class ShipSeeder extends Seeder
{
    public function run() {
        $ship_types = factory(App\ShipType::class, 10)->create();
    }
}
