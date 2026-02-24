<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Speciality;

class SpecialitySeeder extends Seeder
{
    public function run(): void
    {
        $specialities = [
            'Cardiología',
            'Pediatría',
            'Dermatología',
            'Neurología',
            'Ortopedia',
            'Ginecología',
            'Oftalmología',
            'Psiquiatría',
        ];

        foreach ($specialities as $name) {
            Speciality::firstOrCreate(['name' => $name]);
        }
    }
}
