<?php

use Illuminate\Database\Seeder;

class UniverseSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
        // Create Systems
        $systems = factory(App\System::class, 5)->create();

        $registered_sectors = [];

        $systems->each(function ($system) use ($faker, $registered_sectors) {
            // Generate a random number of sectors.
            $max_possible_sectors = ($system->size_x - 1) * ($system->size_y - 1);
            $sector_count         = $faker->numberBetween(0, $max_possible_sectors);

            for ($i = 0; $i < $sector_count; $i++) {

                do {
                    $x = $faker->numberBetween(1, $system->size_x);
                    $y = $faker->numberBetween(1, $system->size_y);
                } while (in_array([$system->id, $x, $y], $registered_sectors));

                $registered_sectors[] = [$system->id, $x, $y];
                factory(App\Sector::class)->create(
                    [
                        'system_id' => $system->id,
                        'x'         => $x,
                        'y'         => $y
                    ]);
            }
        });

        $systems->each(function ($system) use ($faker) {
            $station_count = ceil($system->size_x * $system->size_y / 10);

            for ($i = 0; $i < $station_count; $i++) {
                $x = $faker->numberBetween(1, $system->size_x);
                $y = $faker->numberBetween(1, $system->size_y);

                factory(App\Station::class)->create(
                    [
                        'system_id'  => $system->id,
                        'position_x' => $x,
                        'position_y' => $y
                    ]);
            }

            $planet_count = 5;

            for ($i = 0; $i < $planet_count; $i++) {
                $x = $faker->numberBetween(1, $system->size_x);
                $y = $faker->numberBetween(1, $system->size_y);

                factory(App\Planet::class)->create(
                    [
                        'system_id'  => $system->id,
                        'position_x' => $x,
                        'position_y' => $y
                    ]);
            }

        });


        $jump_node_count = $faker->numberBetween($systems->count() * 2, $systems->count() * 3);

        for ($i = 0; $i < $jump_node_count; $i++) {
            $source_system = $faker->randomElement($systems);

            do {
                $destination_system = $faker->randomElement($systems);
            } while ($source_system === $destination_system);


            // Nodes are two way

            $source = [
                'x' => $faker->numberBetween(1, $source_system->size_x),
                'y' => $faker->numberBetween(1, $source_system->size_y)
            ];

            $destination = [
                'x' => $faker->numberBetween(1, $destination_system->size_x),
                'y' => $faker->numberBetween(1, $destination_system->size_y)
            ];

            $jump_node = new App\JumpNode(
                [
                    'source_system_id'      => $source_system->id,
                    'source_x'              => $source['x'],
                    'source_y'              => $source['y'],
                    'destination_system_id' => $destination_system->id,
                    'destination_x'         => $destination['x'],
                    'destination_y'         => $destination['y'],
                ]);

            $jump_node->save();

            $jump_node_reverse = new App\JumpNode(
                [
                    'source_system_id'      => $destination_system->id,
                    'source_x'              => $destination['x'],
                    'source_y'              => $destination['y'],
                    'destination_system_id' => $source_system->id,
                    'destination_x'         => $source['x'],
                    'destination_y'         => $source['y'],
                ]);

            $jump_node_reverse->save();
        }
    }
}
