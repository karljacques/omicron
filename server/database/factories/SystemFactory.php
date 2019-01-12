<?php

$factory->define(App\System::class, function (Faker\Generator $faker) {
    return [
        'name' => ucwords($faker->unique()->domainWord),
        'size_x' => $faker->numberBetween(5, 25),
        'size_y' => $faker->numberBetween(5, 25)
    ];
});
