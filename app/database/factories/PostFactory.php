<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'image_path' => 'images/' . $faker->unique()->lexify('??????') . '.jpg',
        'caption' => implode(' ', $faker->sentences(3)),
    ];
});
