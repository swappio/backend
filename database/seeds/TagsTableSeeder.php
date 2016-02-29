<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app('db')->table('tags')->insert([
            'name' => 'Watches',
        ]);

        app('db')->table('tags')->insert([
            'name' => 'Wristwatches',
        ]);

        app('db')->table('tags')->insert([
            'name' => 'Accessories',
        ]);

        app('db')->table('tags')->insert([
            'name' => 'Books',
        ]);

        app('db')->table('tags')->insert([
            'name' => 'Music Equipment',
        ]);

        app('db')->table('tags')->insert([
            'name' => 'Various',
        ]);

    }
}
