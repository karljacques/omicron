<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $ship_types = factory(App\ShipType::class, 10)->create();
        $users      = factory(App\User::class, 25)->create();

        $users->push(factory(App\User::class)->create([
                                                          'email' => 'test@omicron.net',
                                                          'name'  => 'Test Account'
                                                      ]));

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

        $users->each(function ($user) use ($faker, $ship_types, $systems) {
            $system = $faker->randomElement($systems);
            $ship   = new App\Ship([
                                       'name'         => 'KMS '. $faker->domainWord,
                                       'user_id'      => $user->id,
                                       'ship_type_id' => $faker->randomElement($ship_types->pluck('id')->all()),
                                       'system_id'    => $system->id,
                                       'position_x'   => $faker->numberBetween(1, $system->size_x),
                                       'position_y'   => $faker->numberBetween(1, $system->size_y),
                                       'fuel'         => 1250
                                   ]);
            $ship->save();

        });

        $jump_node_count = $faker->numberBetween($systems->count() * 5, ($systems->count() * 6) + 10);

        for ($i = 0; $i < $jump_node_count; $i++) {
            $source_system = $faker->randomElement($systems);

            do {
                $destination_system = $faker->randomElement($systems);
            } while ($source_system === $destination_system);

            $jump_node = new App\JumpNode([
                                              'source_system_id'      => $source_system->id,
                                              'source_x'              => $faker->numberBetween(1, $source_system->size_x),
                                              'source_y'              => $faker->numberBetween(1, $source_system->size_y),
                                              'destination_system_id' => $destination_system->id,
                                              'destination_x'         => $faker->numberBetween(1, $destination_system->size_x),
                                              'destination_y'         => $faker->numberBetween(1, $destination_system->size_y),
                                          ]);

            $jump_node->save();
        }
    }
}
