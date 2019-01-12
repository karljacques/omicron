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
        $users = factory(App\User::class, 25)->create();

        $users->push(factory(App\User::class)->create([
            'email' => 'test@omicron.net',
            'name' => 'Test Account'
        ]));

        // Create Systems
        $systems = factory(App\System::class, 5)->create();

        $registered_sectors = [];

        $systems->each(function ($system) use ($faker, $registered_sectors) {
            // Generate a random number of sectors.
            $max_possible_sectors = ($system->size_x - 1) * ($system->size_y - 1);
            $sector_count = $faker->numberBetween(0, $max_possible_sectors);

            for ($i = 0; $i < $sector_count; $i++) {

                do {
                    $x = $faker->numberBetween(1, $system->size_x);
                    $y = $faker->numberBetween(1, $system->size_y);
                } while (in_array([$system->id, $x, $y], $registered_sectors));

                $registered_sectors[] = [$system->id, $x, $y];
                factory(App\Sector::class)->create([
                    'system_id' => $system->id,
                    'x' => $x,
                    'y' => $y
                ]);
            }
        });

        $users->each(function ($user) use ($faker, $ship_types, $systems) {
            $system = $faker->randomElement($systems);
            $ship = new App\Ship([
                'user_id' => $user->id,
                'ship_type_id' => $faker->randomElement($ship_types->pluck('id')->all()),
                'system_id' => $system->id,
                'position_x' => $faker->numberBetween(1, $system->size_x),
                'position_y' => $faker->numberBetween(1, $system->size_y)
            ]);
            $ship->save();

        });
    }
}
