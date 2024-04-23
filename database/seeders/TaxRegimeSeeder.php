<?php

namespace Database\Seeders;

use App\Models\TaxRegime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxRegimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TaxRegime::insert([
            [
                "code" => 601,
                "name" => "General de Ley Personas Morales",
                "fisica" => 0,
                "moral" => 1,
                "start_date" => "2022-01-01"
            ],
            [
                "code" => 603,
                "name" => "Personas Morales con Fines no Lucrativos",
                "fisica" => 0,
                "moral" => 1,
                "start_date" => "2022-01-01"
            ],
            [
                "code" => 605,
                "name" => "Sueldos y Salarios e Ingresos Asimilados a Salarios",
                "fisica" => 1,
                "moral" => 0,
                "start_date" => "2022-01-01"
            ],
            [
                "code" => 606,
                "name" => "Arrendamiento",
                "fisica" => 1,
                "moral" => 0,
                "start_date" => "2022-01-01"
            ],
            [
                "code" => 607,
                "name" => "Régimen de Enajenación o Adquisición de Bienes",
                "fisica" => 1,
                "moral" => 0,
                "start_date" => "2022-01-01"
            ],
            [
                "code" => 608,
                "name" => "Demás ingresos",
                "fisica" => 1,
                "moral" => 0,
                "start_date" => "2022-01-01"
            ],
            [
                "code" => 610,
                "name" => "Residentes en el Extranjero sin Establecimiento Permanente en México",
                "fisica" => 1,
                "moral" => 1,
                "start_date" => "2022-01-01"
            ],
            [
                "code" => 611,
                "name" => "Ingresos por Dividendos (socios y accionistas)",
                "fisica" => 1,
                "moral" => 0,
                "start_date" => "2022-01-01"
            ],
            [
                "code" => 612,
                "name" => "Personas Físicas con Actividades Empresariales y Profesionales",
                "fisica" => 1,
                "moral" => 0,
                "start_date" => "2022-01-01"
            ],
            [
                "code" => 614,
                "name" => "Ingresos por intereses",
                "fisica" => 1,
                "moral" => 0,
                "start_date" => "2022-01-01"
            ],
            [
                "code" => 615,
                "name" => "Régimen de los ingresos por obtención de premios",
                "fisica" => 1,
                "moral" => 0,
                "start_date" => "2022-01-01"
            ],
            [
                "code" => 616,
                "name" => "Sin obligaciones fiscales",
                "fisica" => 1,
                "moral" => 0,
                "start_date" => "2022-01-01"
            ],
            [
                "code" => 620,
                "name" => "Sociedades Cooperativas de Producción que optan por diferir sus ingresos",
                "fisica" => 0,
                "moral" => 1,
                "start_date" => "2022-01-01"
            ],
            [
                "code" => 621,
                "name" => "Incorporación Fiscal",
                "fisica" => 1,
                "moral" => 0,
                "start_date" => "2022-01-01"
            ],
            [
                "code" => 622,
                "name" => "Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras",
                "fisica" => 0,
                "moral" => 1,
                "start_date" => "2022-01-01"
            ],
            [
                "code" => 623,
                "name" => "Opcional para Grupos de Sociedades",
                "fisica" => 0,
                "moral" => 1,
                "start_date" => "2022-01-01"
            ],
            [
                "code" => 624,
                "name" => "Coordinados",
                "fisica" => 0,
                "moral" => 1,
                "start_date" => "2022-01-01"
            ],
            [
                "code" => 625,
                "name" => "Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas",
                "fisica" => 1,
                "moral" => 0,
                "start_date" => "2022-01-01"
            ],
            [
                "code" => 626,
                "name" => "Régimen Simplificado de Confianza",
                "fisica" => 1,
                "moral" => 1,
                "start_date" => "2022-01-01"
            ]
        ]);
    }
}
