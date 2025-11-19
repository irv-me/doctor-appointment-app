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
        User::factory()->create([
            'name' => 'Yam',
            'email' => 'ianrelloso@gmail.com',
            'password' => bcrypt('moguel'),
        ]);
    }}
