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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin',
            'password' => '$2y$12$uEOypAgXAfb9PGw3JezYyONXj6u.lRYxh.9qKc17tIogB0G.MpWiG',
            'documento' => '12345678911'
        ]);
    }
}
