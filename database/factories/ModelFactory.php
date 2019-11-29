<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Movie::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->realText(rand(10, 20)),
        'description' => $faker->realText(rand(100, 400)),
        'releaseDate' => $faker->date('Y-m-d H:i:s'),
        'spokenLang' => $faker->languageCode(),
        'ageRestriction' => $faker->randomDigit(),
        'trailerLink' => $faker->imageUrl(),
        'duration' => $faker->time(),
        'director' => $faker->name(),
        'header_img' => 'https://source.unsplash.com/1024x480',
        'thumbnail_img' => 'https://source.unsplash.com/random/600x400'
    ];
});

$factory->define(App\Actor::class, function(Faker\Generator $faker) {
    $img_url = 'http://graph.facebook.com/v2.5/' . $faker->numberBetween($min = 1000, $max = 900000) . '/picture?height=200&width=200';
    $gender = random_int(0, 1) ? 'man' : 'vrouw';
   return [
       'name' => $faker->firstName(),
       'insertion' => '',
       'surname' => $faker->lastName(),
       'gender' => $gender,
       'country' => $faker->country(),
       'birthDate' => $faker->dateTime(),
       'img' => $img_url
   ];
});

$factory->define(App\Role::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->name(),
        'type_id' => function() {
            return \App\Type::inRandomOrder()->first()->id;
        },
    ];
});

$factory->define(App\ProdComp::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->company(),
        'country' => $faker->country()
    ];
});

$factory->define(App\Actor_Movie::class, function(Faker\Generator $faker) {
    return [
        'movie_id' => function() {
            return \App\Movie::inRandomOrder()->first()->id;
        },
        'actor_id' => function() {
            return \App\Actor::inRandomOrder()->first()->id;
        },
        'role_id' => function() {
            return \App\Role::inRandomOrder()->first()->id;
        },
        'playTime' => $faker->time()
    ];
});

$factory->define(App\Genre_Movie::class, function(Faker\Generator $faker) {
    return [
        'movie_id' => function() {
            return \App\Movie::inRandomOrder()->first()->id;
        },
        'genre_id' => function() {
            return \App\Genre::inRandomOrder()->first()->id;
        }
    ];
});

$factory->define(App\ProdComp_Movie::class, function(Faker\Generator $faker) {
    return [
        'movie_id' => function() {
            return \App\Movie::inRandomOrder()->first()->id;
        },
        'prodcomp_id' => function() {
            return \App\ProdComp::inRandomOrder()->first()->id;
        }
    ];
});

$factory->define(App\Reservation::class, function (Faker\Generator $faker) {
    return [
        'active' => 1,
        'paid' => function () {
            return rand(0,1);
        },
        'user_id' => function () {
            return \App\User::inRandomOrder()->first()->id;
        },
        'state_id' => function () {
            return \App\State::inRandomOrder()->first()->id;
        }
    ];
});

$factory->define(App\Seat::class, function (Faker\Generator $faker) {
    return [
        'active' => 1,
        'paid' => function () {
            return rand(0,1);
        },
        'user_id' => function () {
            return \App\User::inRandomOrder()->first()->id;
        },
        'state_id' => function () {
            return \App\State::inRandomOrder()->first()->id;
        }
    ];
});

$factory->define(App\Review::class, function(Faker\Generator $faker) {
    return [
        'movie_id' => function() {
            return \App\Movie::inRandomOrder()->first()->id;
        },
        'user_id' => function() {
            return \App\User::inRandomOrder()->first()->id;
        },
        'amount' => function() {
            return rand(1, 5);
        }
    ];
});