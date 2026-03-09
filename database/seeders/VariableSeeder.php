<?php

namespace Database\Seeders;

use App\Models\Variable;
use Illuminate\Database\Seeder;

class VariableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variables = [
            [
                'key' => 'PHONE_NUMBER_FOR_CALLS',
                'value' => '515 808 195',
                'description' => 'The main phone number for calls.',
            ],
        ];

        foreach ($variables as $variable) {
            Variable::updateOrCreate(['key' => $variable['key']], $variable);
        }
    }
}
