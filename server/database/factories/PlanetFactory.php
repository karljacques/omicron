<?php

$suffix = [
    'Colony',
    'Prime',
    'Core',
    'II',
    'III',
    'IV',
    'V',
    ''
];

$factory->define(App\Planet::class, function (Faker\Generator $faker) use ($suffix) {
    return [
        'name' =>  ucwords("{$faker->unique()->domainWord} {$faker->randomElement($suffix)}"),
        'population' => $faker->numberBetween(10000, 12000000000)
    ];
});
