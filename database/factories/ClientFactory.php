<?php

/** @var Factory $factory */

use App\Client;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'vat_number' => $faker->regon . 2,
        'street' => $faker->streetAddress,
        'city' => $faker->city,
        'post_code' => $faker->postcode,
        'email' => $faker->companyEmail
    ];
});
