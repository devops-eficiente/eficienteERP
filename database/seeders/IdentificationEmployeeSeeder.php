<?php

namespace Database\Seeders;

use App\Models\IdentificationEmployee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdentificationEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IdentificationEmployee::insert([
            [
                'name' => 'INE'
            ],
            [
                'name' => 'PASAPORTE'
            ],
            [
                'name' => 'OTRO'
            ],
        ]);
    }
}
