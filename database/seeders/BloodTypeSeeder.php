<?php

namespace Database\Seeders;

use App\Models\BloodType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BloodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BloodType::insert([
            [
                'name' => 'O -'
            ],
            [
                'name' => 'O +'
            ],
            [
                'name' => 'A -'
            ],
            [
                'name' => 'A +'
            ],
            [
                'name' => 'B -'
            ],
            [
                'name' => 'B +'
            ],
            [
                'name' => 'AB -'
            ],
            [
                'name' => 'AB +'
            ],
            [
                'name' => 'RH -'
            ],
            [
                'name' => 'RH +'
            ],
            [
                'name' => 'No especificado'
            ],
        ]);
    }
}
