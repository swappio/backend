<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(RatingCriteriaTableSeeder::class);
        $this->call(SwapsTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(FeedbacksTableSeeder::class);

        Model::reguard();
    }
}
