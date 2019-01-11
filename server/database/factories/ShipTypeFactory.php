<?php

$suffix = [
    'Class',
    'Carrier',
    'Cruiser',
    'Battleship',
    'Battlecruiser',
    'Resourcer',
    'Freighter',
    'Gunship',
    'Flyer',
    'Fighter',
    'Scavenger',
    'Escort',
    'Yacht'
];

$factory->define(App\ShipType::class, function (Faker\Generator $faker) use ($suffix) {
    return [
        'name' => ucwords("{$faker->domainWord} {$faker->randomElement($suffix)}")
    ];
});

