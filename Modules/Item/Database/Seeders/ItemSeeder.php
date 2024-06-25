<?php

namespace Modules\Item\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Item\App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::factory()->count(50)->create();
    }
}
