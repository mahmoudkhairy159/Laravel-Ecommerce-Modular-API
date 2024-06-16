<?php

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\User\App\Models\User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [

            'name'       => $this->faker->name,
            'email'      => $this->faker->email,
            'password'   => bcrypt('123456'),
            // 'api_token'  => Str::random(80),
            'status'     => 1,
        ];
    }
}

