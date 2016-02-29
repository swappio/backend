<?php

use Illuminate\Database\Seeder;

class FeedbacksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app('db')->table('feedbacks')->insert([
            'for_user_id' => 2,
            'from_user_id' => 1,
            'criteria_id' => 1,
            'value' => 4,
            'feedback' => 'My Feedback'
        ]);

        app('db')->table('feedbacks')->insert([
            'for_user_id' => 2,
            'from_user_id' => 1,
            'criteria_id' => 2,
            'value' => 5,
            'feedback' => 'My Feedback'
        ]);

        app('db')->table('feedbacks')->insert([
            'for_user_id' => 2,
            'from_user_id' => 1,
            'criteria_id' => 3,
            'value' => 4,
            'feedback' => 'My Feedback'
        ]);

        app('db')->table('feedbacks')->insert([
            'for_user_id' => 2,
            'from_user_id' => 3,
            'criteria_id' => 1,
            'value' => 5,
            'feedback' => 'My Feedback 2'
        ]);

        app('db')->table('feedbacks')->insert([
            'for_user_id' => 2,
            'from_user_id' => 3,
            'criteria_id' => 2,
            'value' => 5,
            'feedback' => 'My Feedback 2'
        ]);

        app('db')->table('feedbacks')->insert([
            'for_user_id' => 2,
            'from_user_id' => 3,
            'criteria_id' => 3,
            'value' => 5,
            'feedback' => 'My Feedback 2'
        ]);

    }
}
