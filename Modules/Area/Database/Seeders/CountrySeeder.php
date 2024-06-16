<?php

namespace Modules\Area\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Area\App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['code' => 'EG', 'name_en' => 'Egypt', 'name_ar' => 'مصر', 'name_sv' => 'Egypten'],
            ['code' => 'AF', 'name_en' => 'Afghanistan', 'name_ar' => 'أفغانستان', 'name_sv' => 'Afghanistan'],
            ['code' => 'AX', 'name_en' => 'Åland Islands', 'name_ar' => 'جزر أولان', 'name_sv' => 'Åland'],
            ['code' => 'AL', 'name_en' => 'Albania', 'name_ar' => 'ألبانيا', 'name_sv' => 'Albanien'],
            ['code' => 'DZ', 'name_en' => 'Algeria', 'name_ar' => 'الجزائر', 'name_sv' => 'Algeriet'],
            ['code' => 'AS', 'name_en' => 'American Samoa', 'name_ar' => 'ساموا الأمريكية', 'name_sv' => 'Amerikanska Samoa'],
            ['code' => 'AD', 'name_en' => 'Andorra', 'name_ar' => 'أندورا', 'name_sv' => 'Andorra'],
            ['code' => 'AO', 'name_en' => 'Angola', 'name_ar' => 'أنغولا', 'name_sv' => 'Angola'],
            ['code' => 'AI', 'name_en' => 'Anguilla', 'name_ar' => 'أنغويلا', 'name_sv' => 'Anguilla'],
            ['code' => 'AQ', 'name_en' => 'Antarctica', 'name_ar' => 'القطب الجنوبي', 'name_sv' => 'Antarktis'],
            ['code' => 'AG', 'name_en' => 'Antigua and Barbuda', 'name_ar' => 'أنتيغوا وبربودا', 'name_sv' => 'Antigua och Barbuda'],
            ['code' => 'AR', 'name_en' => 'Argentina', 'name_ar' => 'الأرجنتين', 'name_sv' => 'Argentina'],
        ];


        foreach ($countries as $country) {
            Country::create([
                'code' => $country['code'],
                'ar' => [
                    'name' => $country['name_ar']
                ],
                'en' => [
                    'name' => $country['name_en']
                ],
                'sv' => [
                    'name' => $country['name_en']
                ],
            ]);
        }
    }
}
