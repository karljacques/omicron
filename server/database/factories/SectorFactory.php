<?php

$factory->define(App\Sector::class, function(Faker\Generator $faker) {
    return [
        'sector_type_id' => $faker->numberBetween(1,5)
    ];
});
