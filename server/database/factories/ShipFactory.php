<?php

$factory->define(App\Ship::class, function(Faker\Generator $faker) {
   return [
       'position_x' => $faker->numberBetween(1, 100),
       'position_y' => $faker->numberBetween(1,100),
       'system' => $faker->numberBetween(1,10)
   ];
});
