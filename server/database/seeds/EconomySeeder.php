<?php

use Illuminate\Database\Seeder;

class EconomySeeder extends Seeder
{
    public function run()
    {
        $faker       = Faker\Factory::create();
        $commodities = [];

        foreach ($this->getCommodities() as $commodity_data) {
            $commodity = new \App\Commodity($commodity_data);
            $commodity->save();

            $commodities[] = $commodity;
        }

        $stations = \App\Station::all();
        $planets  = \App\Planet::all();

        $dockables = [$stations, $planets];

        foreach ($dockables as $dockable_type) {
            foreach ($dockable_type as $dockable) {
                foreach (['buy', 'sell'] as $action) {
                    $dockable_commodities = $this->getSubsetCommodities($commodities);

                    foreach ($dockable_commodities as $dockable_commodity) {
                        try {

                            $dockable->commodities()
                                     ->attach($dockable_commodity->id,
                                              [
                                                  'stock' => $faker->numberBetween(1, 2000),
                                                  $action => $faker->numberBetween(500 * $dockable_commodity->value, 1000 * $dockable_commodity->value)
                                              ]);
                        } catch (Exception $e) {
                        }

                    }
                }
            }
        }
    }

    public function getSubsetCommodities($commodities)
    {
        $faker = Faker\Factory::create();

        $commodities = new \Illuminate\Support\Collection($commodities);
        $number      = $faker->numberBetween(0, count($commodities) / 2);

        return $commodities->random($number)->all();
    }

    public function getCommodities()
    {
        return [
            ['name' => 'Fuel', 'value' => 2, 'cargo_size' => 1],
            ['name' => 'Metals', 'value' => 2, 'cargo_size' => 1],
            ['name' => 'Precious Metals', 'value' => 3, 'cargo_size' => 1],
            ['name' => 'Ore', 'value' => 1, 'cargo_size' => 1],
            ['name' => 'Electronics', 'value' => 2, 'cargo_size' => 1],
            ['name' => 'Medicine', 'value' => 4, 'cargo_size' => 1],
            ['name' => 'Chemicals', 'value' => 2, 'cargo_size' => 1],
            ['name' => 'Machinery', 'value' => 3, 'cargo_size' => 1],
            ['name' => 'Weapons', 'value' => 4, 'cargo_size' => 1],
            ['name' => 'Food', 'value' => 2, 'cargo_size' => 1],
            ['name' => 'Plants', 'value' => 1, 'cargo_size' => 1],
            ['name' => 'Water', 'value' => 1, 'cargo_size' => 1],
            ['name' => 'Oxygen', 'value' => 1, 'cargo_size' => 1]
        ];
    }
}
