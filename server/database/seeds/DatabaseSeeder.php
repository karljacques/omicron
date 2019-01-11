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

        $users->each(function($user) use ($faker, $ship_types) {
            factory(App\Ship::class)->create([
                    'user_id' => $user->id,
                    'ship_type_id' => $faker->randomElement($ship_types->pluck('id')->all())
            ]);
        });
    }
}
