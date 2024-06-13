<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'name'            => 'Super Admin',
            'description'     => 'Administrator role',
            'permission_type' => 'all',
            // 'permissions' => '["admins","settings"]'
        ]);
    }
}
