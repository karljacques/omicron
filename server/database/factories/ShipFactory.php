<?php

$prefix = [
    'Warship',
    'K.M.S.',
    'O.M.S'
];

$factory->define(App\Ship::class, function (Faker\Generator $faker) use ($prefix) {
    $shields = $faker->numberBetween(0, 50) * 100;
    $armour  = $faker->numberBetween(0, 50) * 100;

    return [
        'name' => $faker->randomElement($prefix). ' ' . ucwords($faker->domainWord),

        'fuel'     => 1250,
        'max_fuel' => 1250,

        'power'     => 1000,
        'max_power' => 1000,

        'shields'     => $faker->numberBetween(0, $shields),
        'max_shields' => $shields,

        'armour'     => $faker->numberBetween(0, $armour),
        'max_armour' => $armour,

        'hit_points'     => 100,
        'max_hit_points' => 100,

        'cargo'     => 0,
        'max_cargo' => 100
    ];
});
