<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin / Tenaga Kesehatan
        User::create([
            'name' => 'Dr. Sofia Wijaya',
            'email' => 'admin@medreminder.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Ns. Dewi Kartika',
            'email' => 'perawat@medreminder.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567891',
            'is_active' => true,
        ]);

        // Pasien Hipertensi
        User::create([
            'medical_record_number' => 'RM-2026-001',
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@email.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'phone' => '081234567892',
            'birth_date' => '1965-03-15',
            'gender' => 'male',
            'address' => 'Jl. Merdeka No. 45, Jakarta Selatan',
            'blood_pressure_target' => '130/85',
            'is_active' => true,
        ]);

        User::create([
            'medical_record_number' => 'RM-2026-002',
            'name' => 'Siti Aminah',
            'email' => 'siti.aminah@email.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'phone' => '081234567893',
            'birth_date' => '1970-07-22',
            'gender' => 'female',
            'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
            'blood_pressure_target' => '140/90',
            'is_active' => true,
        ]);

        User::create([
            'medical_record_number' => 'RM-2026-003',
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad.fauzi@email.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'phone' => '081234567894',
            'birth_date' => '1958-11-08',
            'gender' => 'male',
            'address' => 'Jl. Gatot Subroto No. 78, Jakarta Selatan',
            'blood_pressure_target' => '130/80',
            'is_active' => true,
        ]);

        User::create([
            'medical_record_number' => 'RM-2026-004',
            'name' => 'Dewi Lestari',
            'email' => 'dewi.lestari@email.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'phone' => '081234567895',
            'birth_date' => '1972-05-30',
            'gender' => 'female',
            'address' => 'Jl. Thamrin No. 56, Jakarta Pusat',
            'blood_pressure_target' => '135/85',
            'is_active' => true,
        ]);
    }
}
