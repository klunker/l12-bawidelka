<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            [
                'name' => 'Opole',
                'title' => 'Bawidełka Opole',
                'address' => 'ul. Nysy Łużyckiej 62',
                'postal_code' => '45-035',
                'phone' => '515 808 195',
                'facebook' => 'https://www.facebook.com/profile.php?id=100058638086316',
                'instagram' => 'https://www.instagram.com/bawidelka/',
                'active' => true,
                'nip' => '6423140697',
                'regon' => '384385761',
            ],
            [
                'name' => 'Rydułtowy',
                'title' => 'Bawidełka Rydułtowy',
                'address' => 'ul. Bohaterów Warszawy, 3',
                'postal_code' => '44-280',
                'phone' => '609 993 582',
                'facebook' => '',
                'instagram' => 'https://www.instagram.com/bawidelka_rydultowy/',
                'active' => false,
                'nip' => '6423140697',
                'regon' => '384385761',
            ],
        ];

        foreach ($cities as $cityData) {
            City::updateOrCreate(
                ['name' => $cityData['name']],
                $cityData
            );

            $this->command->info("Created city: {$cityData['title']}");
        }

        $this->command->info('Cities seeded successfully!');
    }
}
