<?php

use App\User;
use App\Role;
use App\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Ask for db migration refresh, default is no
        if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
            // disable fk constrain check
            // \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Call the php artisan migrate:refresh
            $this->command->call('migrate:refresh');
            $this->command->warn("Data cleared, starting from blank database.");

            // enable back fk constrain check
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        // Confirm roles needed
        if ($this->command->confirm('Seed all tables? [y|N]', true)) {

            DB::table('foods')->insert(
                [
                    ['productPic' => 'https:\/\/us.coca-cola.com\/content\/dam\/coke2016\/page-properties-images\/Coke_PageProperties.jpg',
                    'product_name' => 'Cola',
                    'product_price' => '2,00'],
                    [
                        'productPic' => 'https://www.austriansupermarket.com//media//catalog//product//cache//2//image//800x800//9df78eab33525d08d6e5fb8d27136e95//r//e//red1007.jpg',
                        'product_name' => 'Red Bull Simply Cola',
                        'product_price' => '2,50'
                    ],
                    [
                        'productPic' => 'https://target.scene7.com//is//image//Target//GUEST_2233bb5e-de0e-4669-a05e-455421d9ac47?wid=488&hei=488&fmt=pjpeg',
                        'product_name' => 'Popcorn',
                        'product_price' => '3,00'
                    ],
                    [
                        'productPic' => 'https://i5.walmartimages.ca//images//Enlarge//862//7_3//999999-59800218627_3.jpg',
                        'product_name' => 'Kit Kat',
                        'product_price' => '2,00'
                    ]
                ]);

            DB::table('users')->insert(
                [
                    'name' => 'Luke Hol',
                    'email' => '0949017@hr.nl',
                    'admin' => true,
                    'password' => bcrypt('secret')
                ]);
            DB::table('users')->insert(
                [
                'name' => 'Sander Vrijenhoek',
                'email' => '0948935@hr.nl',
                'admin' => true,
                'password' => bcrypt('secret')
                ]);
                DB::table('users')->insert(
                    [
                        'name' => 'Martijn Nieuwenhuis',
                        'email' => '0948923@hr.nl',
                        'admin' => true,
                        'password' => bcrypt('secret')
                    ]);
            $this->command->info('Users seeded.');

            DB::table('types')->insert([
                ['title' => 'Hoofdrol'],
                ['title' => 'Bijrol']
            ]);
            $this->command->info('Types seeded.');

            DB::table('states')->insert([
                ['title' => 'canceled'],
                ['title' => 'purchased'],
                ['title' => 'reserved'],
                ['title' => 'past'],
            ]);
            $this->command->info('Reservation states seeded');

            DB::table('movies')->insert([
                [
                    'title' => 'Lego Movie 2: The second part',
                    'description' => 'This is a description',
                    'releaseDate' => '2014-08-11 19:00:37',
                    'spokenLang' => 'Engels',
                    'ageRestriction' => 5,
                    'trailerLink' => 'https://www.youtube.com/embed/11K013qpRR4',
                    'duration' => '01:26:26',
                    'director' => 'Henriette Armstrong',
                    'header_img' => 'https://i.ytimg.com/vi/d2mjUJrma1I/maxresdefault.jpg',
                    'thumbnail_img' => 'https://images.fandango.com/ImageRenderer/200/0/redesign/static/img/default_poster.png/0/images/masterrepository/Fandango/185756/TLM2_TSR_INSTA_VERT_DOM_163.jpg'
                ],
                [
                    'title' => 'Pacific Rim',
                    'description' => 'This is a description',
                    'releaseDate' => '2018-08-16 08:00:00',
                    'spokenLang' => 'Engels',
                    'ageRestriction' => 12,
                    'trailerLink' => 'https://www.youtube.com/embed/2vKz7WnU83E',
                    'duration' => '02:30:26',
                    'director' => 'Henriette Armstrong',
                    'header_img' => 'https://i.pinimg.com/236x/23/e6/43/23e6431eff8b00da1af9b84e08763040--scifi-embed-movies.jpg',
                    'thumbnail_img' => 'https://images.fandango.com/ImageRenderer/200/0/redesign/static/img/default_poster.png/0/images/masterrepository/Fandango/185756/TLM2_TSR_INSTA_VERT_DOM_163.jpg'
                ],
                [
                    'title' => 'Venom',
                    'description' => 'This is a description',
                    'releaseDate' => '2018-08-24 00:00:00',
                    'spokenLang' => 'Engels',
                    'ageRestriction' => 12,
                    'trailerLink' => 'https://www.youtube.com/embed/u9Mv98Gr5pY',
                    'duration' => '02:30:26',
                    'director' => 'Henriette Armstrong',
                    'header_img' => 'https://assets1.ignimgs.com/2018/10/02/venomending-blogroll-1538505459077_1280w.jpg',
                    'thumbnail_img' => 'https://i1.wp.com/herosfact.com/wp-content/uploads/2018/05/Venom-movie-poster.jpg?resize=200%2C250&ssl=1'
                ],
                [
                    'title' => 'Venom',
                    'description' => 'This is a description',
                    'releaseDate' => '2018-08-24 00:00:00',
                    'spokenLang' => 'Engels',
                    'ageRestriction' => 16,
                    'trailerLink' => 'https://www.youtube.com/embed/u9Mv98Gr5pY',
                    'duration' => '02:30:26',
                    'director' => 'Friedrich Champlin',
                    'header_img' => 'https://assets1.ignimgs.com/2018/10/02/venomending-blogroll-1538505459077_1280w.jpg',
                    'thumbnail_img' => 'https://i1.wp.com/herosfact.com/wp-content/uploads/2018/05/Venom-movie-poster.jpg?resize=200%2C250&ssl=1'
                ],
                [
                    'title' => 'The Meg',
                    'description' => 'This is a description',
                    'releaseDate' => '2018-09-21 00:00:00',
                    'spokenLang' => 'Engels',
                    'ageRestriction' => 12,
                    'trailerLink' => 'https://www.youtube.com/embed/GGYXExfKhmo',
                    'duration' => '01:58:26',
                    'director' => 'Florian Williamson',
                    'header_img' => 'https://cdn1.thr.com/sites/default/files/imagecache/scale_crop_768_433/2018/08/meg-fp-0025-h_2018.jpg',
                    'thumbnail_img' => 'https://m.media-amazon.com/images/M/MV5BMjg0MzA4MDE0N15BMl5BanBnXkFtZTgwMzk3MzAwNjM@._V1_UX182_CR0,0,182,268_AL_.jpg'
                ],
                [
                    'title' => 'Crazy Rich Asians',
                    'description' => 'This is a description',
                    'releaseDate' => '2018-07-19 00:00:00',
                    'spokenLang' => 'Engels',
                    'ageRestriction' => 12,
                    'trailerLink' => 'https://lorempixel.com/640/480/?60862',
                    'duration' => '01:58:26',
                    'director' => 'Dominic Kessler',
                    'header_img' => 'https://cdn1.i-scmp.com/sites/default/files/styles/landscape/public/images/methode/2018/09/17/a9c2eed6-b4c5-11e8-89ab-e29b0678280a_1280x720_135442.PNG?itok=XS9M6B9K',
                    'thumbnail_img' => 'http://www.entertainmenthollywood.net/crazy%20rich%20asians.jpg'
                ],
                [
                    'title' => 'Scary Movie 4',
                    'description' => 'This is a description',
                    'releaseDate' => '2018-08-26 00:00:00',
                    'spokenLang' => 'Engels',
                    'ageRestriction' => 12,
                    'trailerLink' => 'https://www.youtube.com/embed/ZQ-YX-5bAs0',
                    'duration' => '01:58:26',
                    'director' => 'Marty Vandervort',
                    'header_img' => 'https://i.ytimg.com/vi/ONRDLjmv_GA/maxresdefault.jpg',
                    'thumbnail_img' => 'http://static.slashingthrough.com/images/movies/scary_movie_v.jpg'
                ],
                [
                    'title' => 'Wreck it Ralph',
                    'description' => 'This is a description',
                    'releaseDate' => '2018-08-26 00:00:00',
                    'spokenLang' => 'Engels',
                    'ageRestriction' => 12,
                    'trailerLink' => 'https://www.youtube.com/embed/87E6N7ToCxs',
                    'duration' => '01:58:26',
                    'director' => 'Prof. Monty Leuschke',
                    'header_img' => 'https://ichef.bbci.co.uk/images/ic/640x360/p06dwmg7.jpg',
                    'thumbnail_img' => 'http://static.slashingthrough.com/images/movies/scary_movie_v.jpg'
                ],
                [
                    'title' => 'A Simple Favor',
                    'description' => 'This is a description',
                    'releaseDate' => '2018-08-28 00:00:00',
                    'spokenLang' => 'Engels',
                    'ageRestriction' => 12,
                    'trailerLink' => 'https://www.youtube.com/embed/_cVlSAD2mRU',
                    'duration' => '01:58:26',
                    'director' => 'Brandi Pfannerstill',
                    'header_img' => 'https://images0.persgroep.net/rcs/RabHZ95Ai1cK9f9yxRC5dIF37cs/diocontent/132829849/_fitwidth/763?appId=93a17a8fd81db0de025c8abd1cca1279&quality=0.8',
                    'thumbnail_img' => 'https://snworksceo.imgix.net/ohi/689fa7f0-42dc-498a-afc1-09ffb902d27b.sized-1000x1000.jpg?w=200'
                ],
                [
                    'title' => 'The Nun',
                    'description' => 'This is a description',
                    'releaseDate' => '2018-08-28 00:00:00',
                    'spokenLang' => 'Engels',
                    'ageRestriction' => 12,
                    'trailerLink' => 'https://www.youtube.com/embed/pzD9zGcUNrw',
                    'duration' => '01:58:26',
                    'director' => 'Justen Williamson MD',
                    'header_img' => 'https://www.thewrap.com/wp-content/uploads/2018/09/the-nun-conjuring-universe-post-credits-scene.jpg',
                    'thumbnail_img' => 'https://freemovie9.online/wp-content/uploads/2018/09/The-Nun-2018-720p-HQ-DVDScr-HQ-Aud-Tamil-Hindi-Eng-Direct-Links.jpg'
                ],
                [
                    'title' => 'The Predator',
                    'description' => 'This is a description',
                    'releaseDate' => '2018-08-28 00:00:00',
                    'spokenLang' => 'Engels',
                    'ageRestriction' => 12,
                    'trailerLink' => 'https://www.youtube.com/embed/WaG1KZqrLvM',
                    'duration' => '01:58:26',
                    'director' => 'Keven Lesch',
                    'header_img' => 'https://www.thewrap.com/wp-content/uploads/2018/09/the-nun-conjuring-universe-post-credits-scene.jpg',
                    'thumbnail_img' => 'https://media.pathe.nl/thumb/180x254/gfx_content/other/api/filmdepot/v1/movie/download/19719_101058_ps_sd-high.jpg'
                ]
            ]);

            DB::table('genres')->insert([
                ['title' => 'Avontuur'],
                ['title' => 'Sci-Fi'],
                ['title' => 'Actie'],
                ['title' => 'Komedie'],
                ['title' => 'Thriller'],
                ['title' => 'Horror'],
                ['title' => 'Fantasie'],
                ['title' => 'Misdaad'],
                ['title' => 'Mysterie'],
                ['title' => 'Oorlog'],
                ['title' => 'Geschiedenis'],
                ['title' => 'Documentaire'],
                ['title' => 'Familie'],
                ['title' => 'Drama'],
                ['title' => 'Romance'],
                ['title' => 'Muziek'],
                ['title' => 'Sport'],
                ['title' => 'Noir'],
                ['title' => 'Western'],
            ]);

            DB::table('genrebestellingen')->insert([
                ['title' => 'Avontuur', 'bestellingen' => 10],
                ['title' => 'Sci-Fi', 'bestellingen' => 5],
                ['title' => 'Actie', 'bestellingen' => 7],
                ['title' => 'Komedie', 'bestellingen' => 8],
                ['title' => 'Thriller', 'bestellingen' => 5],
                ['title' => 'Horror', 'bestellingen' => 0],
                ['title' => 'Fantasie', 'bestellingen' =>1],
                ['title' => 'Misdaad', 'bestellingen' => 20],
                ['title' => 'Mysterie', 'bestellingen' => 0],
                ['title' => 'Oorlog', 'bestellingen' => 0],
                ['title' => 'Geschiedenis', 'bestellingen' => 0],
                ['title' => 'Documentaire', 'bestellingen' => 0],
                ['title' => 'Familie','bestellingen' => 0],
                ['title' => 'Drama', 'bestellingen' => 0],
                ['title' => 'Romance', 'bestellingen' =>0],
                ['title' => 'Muziek', 'bestellingen' => 0],
                ['title' => 'Sport', 'bestellingen' =>0],
                ['title' => 'Noir', 'bestellingen' => 0],
                ['title' => 'Western','bestellingen' => 0],
            ]);
            DB::table('bezoekers')->insert([
                ['maand' => 'jan', 'bezoeker' => 10],
                ['maand' => 'feb', 'bezoeker' => 5],
                ['maand' => 'mrt', 'bezoeker' => 7],
                ['maand' => 'apr', 'bezoeker' => 8],
                ['maand' => 'mei', 'bezoeker' => 5],
                ['maand' => 'jun', 'bezoeker' => 0],
                ['maand' => 'jul', 'bezoeker' =>1],
                ['maand' => 'aug', 'bezoeker' => 20],
                ['maand' => 'sep', 'bezoeker' => 0],
                ['maand' => 'okt', 'bezoeker' => 0],
                ['maand' => 'nov', 'bezoeker' => 0],
                ['maand' => 'dec', 'bezoeker' => 0],
            ]);

            // now lets seed some bids for demo
            factory(\App\Role::class, 5)->create();
            $this->command->info('Some Role data seeded.');

            // now lets seed some bids for demo
            factory(\App\Actor::class, 1000)->create();
            $this->command->info('Some Actor data seeded.');

            // now lets seed some bids for demo
            factory(\App\ProdComp::class, 8)->create();
            $this->command->info('Some ProdComp data seeded.');

            // now lets seed some pivots for demo
            factory(\App\Actor_Movie::class, 150)->create();
            factory(\App\Genre_Movie::class, 500)->create();
            factory(\App\ProdComp_Movie::class, 20)->create();

            factory(\App\Review::class, 200)->create();

            $this->command->warn('All done :)');
        }

    }
}