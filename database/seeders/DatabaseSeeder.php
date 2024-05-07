<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            BloodTypeSeeder::class,
            IdentificationEmployeeSeeder::class,
            InstituteHealthSeeder::class,
            MaritalStatusSeeder::class,
            TaxRegimeSeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            CapitalRegimeSeeder::class,
        ]);
    }
}
