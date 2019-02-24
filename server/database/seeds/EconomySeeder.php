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
                                                  $action => $faker->numberBetween(0, 1000)
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
        $number      = $faker->numberBetween(0, count($commodities));

        return $commodities->random($number)->all();
    }

    public function getCommodities()
    {
        return [
            ['name' => 'Fuel', 'value' => 1, 'cargo_size' => 1],
            ['name' => 'Metals', 'value' => 1, 'cargo_size' => 1],
            ['name' => 'Precious Metals', 'value' => 1, 'cargo_size' => 1],
            ['name' => 'Ore', 'value' => 1, 'cargo_size' => 1],
            ['name' => 'Electronics', 'value' => 1, 'cargo_size' => 1],
            ['name' => 'Medicine', 'value' => 1, 'cargo_size' => 1],
            ['name' => 'Chemicals', 'value' => 1, 'cargo_size' => 1],
            ['name' => 'Machinery', 'value' => 1, 'cargo_size' => 1],
            ['name' => 'Weapons', 'value' => 1, 'cargo_size' => 1],
            ['name' => 'Food', 'value' => 1, 'cargo_size' => 1],
            ['name' => 'Plants', 'value' => 1, 'cargo_size' => 1],
            ['name' => 'Water', 'value' => 1, 'cargo_size' => 1],
            ['name' => 'Oxygen', 'value' => 1, 'cargo_size' => 1]
        ];
    }
}
