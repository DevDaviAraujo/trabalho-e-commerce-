<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Categoria;
use App\Models\SubCategoria;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Admin::create([
            'name' => 'admin',
            'email' => 'admin@admin',
            'password' => '$2y$12$uEOypAgXAfb9PGw3JezYyONXj6u.lRYxh.9qKc17tIogB0G.MpWiG',
            'documento' => '12345678911'
        ]);

        Categoria::create([

            'descricao' => 'Sem categoria',
            
        ]);

        SubCategoria::create([

            'categoria_id' => 1,
            'descricao' => 'Sem sub-categoria',
            
        ]);

    }
}
