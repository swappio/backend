<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app('db')->table('users')->insert([
            'email' => 'admin@admin.com',
            'password' => app('hash')->make('admin'),
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        app('db')->table('users')->insert([
            'email' => 'gregory@gregory.com',
            'password' => app('hash')->make('gregory'),
            'first_name' => 'Gregory',
            'last_name' => 'Muryn-Mukha',
            'location' => 'San Francisco, CA, USA',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        app('db')->table('users')->insert([
            'email' => 'nester@nester.com',
            'password' => app('hash')->make('nester'),
            'first_name' => 'Andrew',
            'last_name' => 'Nester',
            'location' => 'Munchen, Germany',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        app('db')->table('users')->insert([
            'email' => 'ivan@ivan.com',
            'password' => app('hash')->make('ivan'),
            'first_name' => 'Ivan',
            'last_name' => 'Smirnov',
            'location' => 'Moscow, Russia',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
    }
}
