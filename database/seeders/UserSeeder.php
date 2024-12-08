<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * تنفيذ عملية الـ Seeding.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create(); // إنشاء 10 مستخدمين وهميين
    }
}
