<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; // Verifica que tu modelo se llame Role

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['role' => 'Gerente'],        // ID 1
            ['role' => 'Coordinador'],    // ID 2
            ['role' => 'Verificador'],    // ID 3
            ['role' => 'Distribuidora'],  // ID 4
            ['role' => 'Cajera'],         // ID 5
        ];

        foreach ($roles as $r) {
            Role::create($r);
        }
    }
}