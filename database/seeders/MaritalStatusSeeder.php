<?php

namespace Database\Seeders;

use App\Models\MaritalStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaritalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MaritalStatus::insert([
            [
                'name' => 'Casado (A)'
            ],
            [
                'name' => 'Divorciado (A)'
            ],
            [
                'name' => 'Soltero (A)'
            ],
            [
                'name' => 'Union Libre'
            ],
            [
                'name' => 'No Especificado'
            ],
        ]);
    }
}
