<?php

namespace Database\Seeders;

use App\Models\InstituteHealth;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstituteHealthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InstituteHealth::insert([
            [
                'acronym' => 'IMSS',
                'name' => 'Instituto Mexicano del Seguro Social',
            ],
            [
                'acronym' => 'ISSSTE',
                'name' => 'Instituto de Seguridad y Servicios Sociales de los Trabajadores del Estado',
            ],
            [
                'acronym' => 'SP',
                'name' => 'Seguro Popular',
            ],
            [
                'acronym' => 'ISSDN',
                'name' => 'Instituciones de Salud de la Secretaría de la Defensa Nacional',
            ],
            [
                'acronym' => 'Otro',
                'name' => 'Otro',
            ],
        ]);
    }
}
