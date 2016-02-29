<?php

use Illuminate\Database\Seeder;

class SwapsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app('db')->table('swaps')->insert([
            'user_id' => 2,
            'name' => 'Rare vintage mens watch 1956',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ]);

        app('db')->table('swaps')->insert([
            'user_id' => 2,
            'name' => 'Mens watch',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ]);

        app('db')->table('swaps')->insert([
            'user_id' => 3,
            'name' => 'Rare Fender Guitar',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ]);

        app('db')->table('swap_photos')->insert([
            'swap_id' => 1,
            'is_title_photo' => true,
            'url' => '/upload/1.png'
        ]);

        // PHOTOS

        app('db')->table('swap_photos')->insert([
            'swap_id' => 1,
            'is_title_photo' => false,
            'url' => '/upload/2.png'
        ]);

        app('db')->table('swap_photos')->insert([
            'swap_id' => 2,
            'is_title_photo' => true,
            'url' => '/upload/3.png'
        ]);

        app('db')->table('swap_photos')->insert([
            'swap_id' => 2,
            'is_title_photo' => true,
            'url' => '/upload/4.png'
        ]);

        // TAGS

        app('db')->table('swap_tags')->insert([
            'swap_id' => 1,
            'tag_id' => 1,
        ]);

        app('db')->table('swap_tags')->insert([
            'swap_id' => 1,
            'tag_id' => 2,
        ]);

        app('db')->table('swap_tags')->insert([
            'swap_id' => 1,
            'tag_id' => 3,
        ]);

        app('db')->table('swap_tags')->insert([
            'swap_id' => 2,
            'tag_id' => 1,
        ]);

        app('db')->table('swap_tags')->insert([
            'swap_id' => 2,
            'tag_id' => 2,
        ]);

        app('db')->table('swap_tags')->insert([
            'swap_id' => 2,
            'tag_id' => 3,
        ]);

        app('db')->table('swap_tags')->insert([
            'swap_id' => 3,
            'tag_id' => 5,
        ]);

        // WISHES

        app('db')->table('wishes')->insert([
            'name' => 'Book',
        ]);

        app('db')->table('wishes')->insert([
            'name' => 'Car',
        ]);

        app('db')->table('wishes')->insert([
            'name' => 'Watch',
        ]);

        app('db')->table('wishes')->insert([
            'name' => 'Anything',
        ]);

        app('db')->table('swap_wishes')->insert([
            'swap_id' => 1,
            'wish_id' => 1,
        ]);

        app('db')->table('swap_wishes')->insert([
            'swap_id' => 1,
            'wish_id' => 2,
        ]);

        app('db')->table('swap_wishes')->insert([
            'swap_id' => 2,
            'wish_id' => 3,
        ]);

        app('db')->table('swap_wishes')->insert([
            'swap_id' => 3,
            'wish_id' => 1,
        ]);

        app('db')->table('swap_wishes')->insert([
            'swap_id' => 3,
            'wish_id' => 4,
        ]);
    }
}
