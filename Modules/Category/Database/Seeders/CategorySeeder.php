<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {




        Category::create([
            'code' => 'fw',
            'status' => 1,
            'en' => [
                'name' => 'fires',
                'description' => 'fires description'
            ],
            'ar' => [
                'name' => 'حرائق',
                'description' => 'حرائق'
            ]
        ]);
        Category::create([
            'code' => 'xyz',
            'status' => 1,
            'en' => [
                'name' => 'storms',
                'description' => 'storms description'
            ],
            'ar' => [
                'name' => 'اعاصير',
                'description' => 'اعاصير'
            ]
        ]);
    }
}
