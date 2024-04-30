<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        State::insert([
            [
                'name' => 'Aguascalientes',
                'iso' => 'AGS',
                'country_id' => 121,
            ],
            [
                'name' => 'Baja California',
                'iso' => 'BC',
                'country_id' => 121,
            ],
            [
                'name' => 'Baja California Sur',
                'iso' => 'BCS',
                'country_id' => 121,
            ],
            [
                'name' => 'Campeche',
                'iso' => 'CMP',
                'country_id' => 121,
            ],
            [
                'name' => 'Chiapas',
                'iso' => 'CHS',
                'country_id' => 121,
            ],
            [
                'name' => 'Chihuahua',
                'iso' => 'CHI',
                'country_id' => 121,
            ],
            [
                'name' => 'Ciudad de México',
                'iso' => 'CMX',
                'country_id' => 121,
            ],
            [
                'name' => 'Coahuila de Zaragoza',
                'iso' => 'COA',
                'country_id' => 121,
            ],
            [
                'name' => 'Colima',
                'iso' => 'COL',
                'country_id' => 121,
            ],
            [
                'name' => 'Durango',
                'iso' => 'DGO',
                'country_id' => 121,
            ],
            [
                'name' => 'Estado de México ',
                'iso' => 'MEX',
                'country_id' => 121,
            ],
            [
                'name' => 'Guanajuato ',
                'iso' => 'GTO',
                'country_id' => 121,
            ],
            [
                'name' => 'Guerrero ',
                'iso' => 'GRO',
                'country_id' => 121,
            ],
            [
                'name' => 'Hidalgo ',
                'iso' => 'HGO',
                'country_id' => 121,
            ],
            [
                'name' => 'Jalisco ',
                'iso' => 'JAL',
                'country_id' => 121,
            ],
            [
                'name' => 'Michoacán',
                'iso' => 'MCH',
                'country_id' => 121,
            ],
            [
                'name' => 'Morelos ',
                'iso' => 'MOR',
                'country_id' => 121,
            ],
            [
                'name' => 'Nayarit ',
                'iso' => 'NAY',
                'country_id' => 121,
            ],
            [
                'name' => 'Nuevo León',
                'iso' => 'NL',
                'country_id' => 121,
            ],
            [
                'name' => 'Oaxaca',
                'iso' => 'OAX',
                'country_id' => 121,
            ],
            [
                'name' => 'Puebla',
                'iso' => 'PUE',
                'country_id' => 121,
            ],
            [
                'name' => 'Querétaro',
                'iso' => 'QRO',
                'country_id' => 121,
            ],
            [
                'name' => 'Quintana Roo',
                'iso' => 'QR',
                'country_id' => 121,
            ],
            [
                'name' => 'San Luis Potosí',
                'iso' => 'SLP',
                'country_id' => 121,
            ],
            [
                'name' => 'Sinaloa',
                'iso' => 'SIN',
                'country_id' => 121,
            ],
            [
                'name' => 'Sonora',
                'iso' => 'SON',
                'country_id' => 121,
            ],
            [
                'name' => 'Tabasco',
                'iso' => 'TAB',
                'country_id' => 121,
            ],
            [
                'name' => 'Tamaulipas',
                'iso' => 'TMS',
                'country_id' => 121,
            ],
            [
                'name' => 'Tlaxcala',
                'iso' => 'TLX',
                'country_id' => 121,
            ],
            [
                'name' => 'Veracruz',
                'iso' => 'VER',
                'country_id' => 121,
            ],
            [
                'name' => 'Yucatán',
                'iso' => 'YUC',
                'country_id' => 121,
            ],
            [
                'name' => 'Zacatecas',
                'iso' => 'ZAC',
                'country_id' => 121,
            ],
        ]);
    }
}
