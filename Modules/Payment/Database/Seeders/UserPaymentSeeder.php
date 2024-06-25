<?php

namespace Modules\Payment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Payment\App\Models\UserPayment;
use Modules\User\App\Models\User;

class UserPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [

            [
                'name' => 'Mahmoud Khairy',
                'card_type' => 'Visa',
                'card_number' => '4111111111111111',
                'user_id' => User::inRandomOrder()->value('id') ?? User::factory()->create()->id,
            ],

        ];
        foreach ($items as $item) {
            $UserPayment = UserPayment::Create($item);
        }
    }
}
