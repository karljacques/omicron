<?php

use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();

        $users = factory(App\User::class, 25)->create();

        $users->push(factory(App\User::class)->create(
            [
                'email' => 'test@omicron.net',
                'name'  => 'Test Account'
            ]));

        $characters = new \Illuminate\Support\Collection();
        $users->each(function ($user) use ($characters, $faker) {
            $character = new \App\Character(
                [
                    'name'    => $faker->name,
                    'user_id' => $user->id,
                    'money'   => 100000
                ]);

            $character->save();

            $characters->push($character);
        });

        $ship_types = \App\ShipType::all();
        $systems    = \App\System::all();

        $characters->each(function ($character) use ($faker, $ship_types, $systems) {
            $system = $faker->randomElement($systems);

            factory(App\Ship::class)->create(
                [
                    'character_id' => $character->id,
                    'ship_type_id' => $faker->randomElement($ship_types->pluck('id')->all()),
                    'system_id'    => $system->id,
                    'position_x'   => $faker->numberBetween(1, $system->size_x),
                    'position_y'   => $faker->numberBetween(1, $system->size_y)
                ]);
        });
    }
}
