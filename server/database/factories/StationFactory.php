<?php

$suffix = [
    'Port',
    'Station',
    'Dock',
    'Harbour',
    'Yards',
    'Docks',
    'Fleet Yards'
];

$factory->define(App\Station::class, function (Faker\Generator $faker) use ($suffix) {
   return [
        'name' =>  ucwords("{$faker->unique()->domainWord} {$faker->randomElement($suffix)}"),
        'capacity' => $faker->numberBetween(5,10)
   ];
});
