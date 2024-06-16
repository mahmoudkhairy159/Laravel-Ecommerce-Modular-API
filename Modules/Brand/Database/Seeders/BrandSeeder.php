<?php

namespace Modules\Brand\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Brand\App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {




        Brand::create([
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
        Brand::create([
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
