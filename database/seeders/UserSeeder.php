<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Administrador',
            'email' => 'admin@eficiente.com',
            // 'email_verified_at' => now(),
            'password' => '123456789',
        ]);

        $user->assignRole('super_admin');
    }
}
