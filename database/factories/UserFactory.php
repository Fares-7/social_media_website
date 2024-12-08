<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    /**
     * اسم النموذج المرتبط بالـ Factory.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * تحديد حالة النموذج الافتراضية.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // يمكن تغيير كلمة المرور الافتراضية
            'remember_token' => Str::random(10),
        ];
    }
}
