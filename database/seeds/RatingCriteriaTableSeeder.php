<?php

use Illuminate\Database\Seeder;

class RatingCriteriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app('db')->table('rating_criteria')->insert([
            'name' => 'Item as declared',
        ]);

        app('db')->table('rating_criteria')->insert([
            'name' => 'Communication',
        ]);

        app('db')->table('rating_criteria')->insert([
            'name' => 'Response Time',
        ]);

    }
}
