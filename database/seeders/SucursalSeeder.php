<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sucursal; // Asegúrate de que el modelo se llame Sucursal

class SucursalSeeder extends Seeder
{
    public function run(): void
    {
        $sucursales = [
            [
                'nombre'    => 'Prestamo_Facil',
                'municipio' => 'Gómez Palacio',
            ],
            [
                'nombre'    => 'Prestamo_Facil',
                'municipio' => 'Lerdo',
            ],
            [
                'nombre'    => 'Prestamo_Facil',
                'municipio' => 'Durango',
            ],
            [
                'nombre'    => 'Prestamo_Facil',
                'municipio' => 'Torreón',
            ],
        ];

        foreach ($sucursales as $s) {
            Sucursal::create($s);
        }
    }
}