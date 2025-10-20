<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // llamar a RoleSeeder
        $this->call(RoleSeeder::class);

        // Crear un usuario de prueba
        //php artisan migrate:fresh -seed
        User::factory()->create([
            'name' => 'Nugget de Pollo',
            'email' => 'estebanpriego2005@gmail.com',
            'password' => bcrypt('Moguel2005'),
        ]);
    }
}
