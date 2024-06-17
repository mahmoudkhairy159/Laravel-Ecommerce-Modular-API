<?php

namespace Modules\Payment\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserPaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Payment\App\Models\UserPayment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

