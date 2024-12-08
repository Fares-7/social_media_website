<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tweet;
use App\Models\User;

class TweetFactory extends Factory
{
    /**
     * اسم النموذج المرتبط بالـ Factory.
     *
     * @var string
     */
    protected $model = Tweet::class;

    /**
     * تحديد حالة النموذج الافتراضية.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(), // ربط التغريدة بمستخدم عشوائي
            'text' => $this->faker->sentence(),
        ];
    }
}
