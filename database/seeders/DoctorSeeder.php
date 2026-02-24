<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Speciality;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $cardiologia = Speciality::where('name', 'Cardiología')->first();

        $user = User::where('email', 'jhony@example.com')->first();

        if ($user) {
            Doctor::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'speciality_id'          => $cardiologia?->id,
                    'medical_license_number' => null,
                    'biography'              => null,
                ]
            );
        }
    }
}
