<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'               => User::factory(),
            'speciality_id'         => null,
            'medical_license_number' => fake()->numerify('LIC-#######'),
            'biography'             => fake()->paragraph(),
            'schedule'              => null,
        ];
    }
}
