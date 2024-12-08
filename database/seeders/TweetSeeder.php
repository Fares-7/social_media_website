<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tweet;

class TweetSeeder extends Seeder
{
    /**
     * تنفيذ عملية الـ Seeding.
     *
     * @return void
     */
    public function run()
    {
        Tweet::factory(30)->create(); // إنشاء 30 تغريدة وهمية
    }
}
