<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlojamientosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Deshabilitar claves foráneas temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncar la tabla
        DB::table('alojamientos')->truncate();

        // Volver a habilitar claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('alojamientos')->insert([
            [
                'id' => 1,
                'nombre' => 'Hotel San Salvador',
                'ubicacion' => 'Centro de San Salvador, El Salvador',
                'precio' => 85.00,
                'descripcion' => 'Hotel moderno con desayuno incluido y piscina al aire libre.',
                'cpacidad' => 80,
                'id_tipo_alojamiento' => 1, //Hotel
                'imagen' => 'images/3w4LMaatT870TmjyM6xo5lilfj6tJWVzW6VH9Jv6.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nombre' => 'Resort Costa del Sol',
                'ubicacion' => 'Playa Costa del Sol, La Paz, El Salvador',
                'precio' => 210.00,
                'descripcion' => 'Resort frente al mar con spa, restaurante y acceso privado a la playa.',
                'cpacidad' => 150,
                'id_tipo_alojamiento' => 2, //Resort
                'imagen' => 'images/5uWPfzqsu5p62CeCwI62lh0Ev7RKtXX0gpDSkNoB.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nombre' => 'Cabaña Los Pinos',
                'ubicacion' => 'Montaña de Chalatenango, El Salvador',
                'precio' => 65.00,
                'descripcion' => 'Cabaña rústica rodeada de pinos, ideal para escapadas románticas.',
                'cpacidad' => 4,
                'id_tipo_alojamiento' => 3, // Cabaña
                'imagen' => 'images/dwyCHSZw3KCk5N2nFHPbTLeSkmCxQj0Dr1LsYTTU.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'nombre' => 'Hostal El Peregrino',
                'ubicacion' => 'Suchitoto, Cuscatlán, El Salvador',
                'precio' => 35.00,
                'descripcion' => 'Hostal acogedor con vista al lago, desayuno incluido.',
                'cpacidad' => 20,
                'id_tipo_alojamiento' => 4, // Hostal
                'imagen' => 'images/VGU8w5Yd3eTGg2cU4hHSyxXyM1QIqzOYvrhS5wKV.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'nombre' => 'Casa de Campo La Esperanza',
                'ubicacion' => 'Concepción de Ataco, Ahuachapán, El Salvador',
                'precio' => 90.00,
                'descripcion' => 'Casa campestre con chimenea, jardín y vista panorámica.',
                'cpacidad' => 8,
                'id_tipo_alojamiento' => 5, // Casa de campo
                'imagen' => 'images/uRar65xz40tZSsGSlE0V3EuNG3AFpZImqOFaW58g.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
