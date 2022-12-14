<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PostTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(PostTableSeeder::class);
    }
}
