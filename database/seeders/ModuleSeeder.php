<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Module::insert([
            [
                'name' => 'Empleados'
            ],
            [
                'name' => 'Clientes'
            ],
            [
                'name' => 'Finanzas'
            ],
            [
                'name' => 'Contabilidad'
            ],
            [
                'name' => 'Reportes'
            ],
            [
                'name' => 'Nominas'
            ],
        ]);
    }
}
