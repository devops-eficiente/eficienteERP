<?php

namespace Database\Seeders;

use App\Models\CapitalRegime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CapitalRegimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CapitalRegime::insert([
            [
                "acronym" => "ABP",
                "name" => "Asociación de Beneficencia Privada"
            ],
            [
                "acronym" => "AC",
                "name" => "Asociación Civil"
            ],
            [
                "acronym" => "AR",
                "name" => "Asociación Religiosa"
            ],
            [
                "acronym" => "ARIC DE RL DE CV",
                "name" => "Asociación Rural de Interés Colectivo de Responsabilidad Limitada de Capital Variable"
            ],
            [
                "acronym" => "IAP",
                "name" => "Institución de Asistencia Privada"
            ],
            [
                "acronym" => "S DE RL",
                "name" => "Sociedad de Responsabilidad Limitada"
            ],
            [
                "acronym" => "S DE RL DE CV",
                "name" => "Sociedad de Responsabilidad Limitada de Capital Variable"
            ],
            [
                "acronym" => "S DE RL MI",
                "name" => "Sociedad de Responsabilidad Microindustrial"
            ],
            [
                "acronym" => "S EN NC",
                "name" => "Sociedad en Nombre Colectivo"
            ],
            [
                "acronym" => "SA",
                "name" => "Sociedad Anónima"
            ],
            [
                "acronym" => "SA DE CV",
                "name" => "Sociedad Anónima de Capital Variable"
            ],
            [
                "acronym" => "SA DE CV SOFOM ENR",
                "name" => "Sociedad Anónima de Capital Variable SOFOM Entidad No Regulada"
            ],
            [
                "acronym" => "SA DE CV SOFOM ER",
                "name" => "Sociedad Anónima de Capital Variable SOFOM Entidad Regulada"
            ],
            [
                "acronym" => "SA DE RL DE CV",
                "name" => "Sociedad Anónima de Responsabilidad Limitada de Capital Variable"
            ],
            [
                "acronym" => "SA INSTITUCIÓN DE BANCA MÚLTIPLE",
                "name" => "Sociedad Anónima Institución de Banca Múltiple"
            ],
            [
                "acronym" => "SAB DE CV",
                "name" => "Sociedad Anónima Bursátil de Capital Variable"
            ],
            [
                "acronym" => "SAPI DE CV",
                "name" => "Sociedad Anónima Promotora de la Inversión de Capital Variable"
            ],
            [
                "acronym" => "SAPI DE CV SOFOM ENR",
                "name" => "Sociedad Anónima Promotora de la Inversión de Capital Variable SOFOM Entidad No regulada"
            ],
            [
                "acronym" => "SAS",
                "name" => "Sociedad por Acciones Simplificada"
            ],
            [
                "acronym" => "SAS DE CV",
                "name" => "Sociedad por Acciones Simplificada de Capital Variable"
            ],
            [
                "acronym" => "SC",
                "name" => "Sociedad Civil"
            ],
            [
                "acronym" => "SC DE AP DE RL",
                "name" => "Sociedad Cooperativa de Ahorro y Préstamo de Responsabilidad Limitada"
            ],
            [
                "acronym" => "SC DE AP DE RL DE CV",
                "name" => "Sociedad Cooperativa de Ahorro y Préstamo de Responsabilidad Limitada de Capital Variable"
            ],
            [
                "acronym" => "SC DE RL",
                "name" => "Sociedad Cooperativa de Responsabilidad Limitada"
            ],
            [
                "acronym" => "SC DE RL DE CV",
                "name" => "Sociedad Cooperativa de Responsabilidad Limitada de Capital Variable"
            ],
            [
                "acronym" => "SPR DE RL",
                "name" => "Sociedad de Producción Rural de Responsabilidad Limitada"
            ],
            [
                "acronym" => "SPR DE RL DE CV",
                "name" => "Sociedad de Producción Rural de Responsabilidad Limitada de Capital Variable"
            ]
        ]);
    }
}
