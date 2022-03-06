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
            'ho' => $this->faker->ho,
            'ten' => $this->faker->ten,
            'tuoi' => $this->faker->tuoi,
            'dia_chi' => $this->faker->dia_chi,
            'so_DT' => $this->faker->so_DT,
            'CMND' => $this->faker->CMND,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt("123456"),
            'remember_token' => Str::random(10),
        ];
    }
}
