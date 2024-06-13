<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Admin\App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name'       => 'Mahmoud Khairy',
            'email'      => 'mahmoud.khairy@wardlin.com',
            'password'   => '12345678',
            'status'     => 1,
            'role_id'    => 1,
        ]);
    }
}
