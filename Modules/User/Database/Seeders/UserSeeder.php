<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\User\App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [

            [
                'name'       => 'Mahmoud Khairy',
                'email'      => 'mahmoud.khairy@wardlin.com',
                'password'   => '12345678',
                'verified_at'   => '2023-10-07T19:22:09.000000Z',

            ],
         
        ];
        foreach ($items as $item) {
            $user = User::Create($item);
            $user->profile()->create();
        }
    }
}
