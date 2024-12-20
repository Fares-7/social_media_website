<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * تنفيذ عملية الـ Seeding.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            TweetSeeder::class,
        ]);
    }
}
