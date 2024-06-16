<?php

namespace Modules\Area\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Area\App\Models\City;
use Modules\Area\App\Models\Country;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['code' => 'C1', 'name_en' => 'Cairo', 'name_ar' => 'القاهرة', 'name_sv' => 'Kairo'],
            ['code' => 'ALX', 'name_en' => 'Alexandria', 'name_ar' => 'الإسكندرية', 'name_sv' => 'Alexandria'],
        ];


        foreach ($cities as $city) {
            City::create([
                'code' => $city['code'],
                'country_id' => 1,
                'ar' => [
                    'name' => $city['name_ar']
                ],
                'en' => [
                    'name' => $city['name_en']
                ],
                'sv' => [
                    'name' => $city['name_en']
                ],
            ]);
        }
    }
}
