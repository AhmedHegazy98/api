<?php

use Faker\Generator as Faker;
// you can visit the documentaion on github and laravel docs
$factory->define(App\Model\Product::class, function (Faker $faker) {
    return [

        'name'=>$faker->word,
        'detail'=>$faker->paragraph,
        'price'=>$faker->numberBetween(100,1000),
        'stock'=>$faker->randomDigit,
        'discount'=>$faker->numberBetween(2,30),
    ];
});
