<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria; // Asegúrate de que el modelo exista

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            [
                'categoria' => 'Bronce',
                'porcentaje_comision' => 3.00,
            ],
            [
                'categoria' => 'Plata',
                'porcentaje_comision' => 6.00,
            ],
            [
                'categoria' => 'Oro',
                'porcentaje_comision' => 10.00,
            ],
        ];

        foreach ($categorias as $cat) {
            Categoria::create($cat);
        }
    }
}