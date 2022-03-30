<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'age' => $this->faker->randomNumber(),
            'address' => $this->faker->address,
            'phonenumber' => $this->faker->phoneNumber,
            'person_id' => $this->faker->randomNumber(),
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'admin' => false,
            'password' => bcrypt("123456"),
            'remember_token' => Str::random(10),
        ];
    }
}
