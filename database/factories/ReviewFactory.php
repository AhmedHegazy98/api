<?php

use Faker\Generator as Faker;
use App\Model\Product;
// you can visit the documentaion on github and laravel docs
$factory->define(App\Model\Review::class, function (Faker $faker) {
    return [
        'product_id'=>function()
        {
            return Product::all()->random();
        },
        'customer'=>$faker->name,
        'review'=>$faker->paragraph,
        'star'=>$faker->numberBetween(0,5),
        
    ];
});
