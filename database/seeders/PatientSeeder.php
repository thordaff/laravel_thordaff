<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [
            [
                'nama_pasien' => 'Budi Santoso',
                'alamat' => 'Jl. Sudirman No. 10, Jakarta',
                'no_telepon' => '081234567890',
                'hospital_id' => 1
            ],
            [
                'nama_pasien' => 'Ani Wijaya',
                'alamat' => 'Jl. Thamrin No. 20, Jakarta',
                'no_telepon' => '081234567891',
                'hospital_id' => 1
            ],
            [
                'nama_pasien' => 'Citra Dewi',
                'alamat' => 'Jl. Kuningan No. 30, Jakarta',
                'no_telepon' => '081234567892',
                'hospital_id' => 2
            ],
            [
                'nama_pasien' => 'Doni Pratama',
                'alamat' => 'Jl. Rasuna Said No. 40, Jakarta',
                'no_telepon' => '081234567893',
                'hospital_id' => 3
            ]
        ];

        foreach ($patients as $patient) {
            Patient::create($patient);
        }
    }
}