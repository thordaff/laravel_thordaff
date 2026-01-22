<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hospital;

class HospitalSeeder extends Seeder
{
    public function run(): void
    {
        $hospitals = [
            [
                'nama_rumah_sakit' => 'RS Siloam',
                'alamat' => 'Jl. Gatot Subroto No. 1, Jakarta',
                'email' => 'info@siloam.co.id',
                'telepon' => '021-1234567'
            ],
            [
                'nama_rumah_sakit' => 'RS Harapan Kita',
                'alamat' => 'Jl. Letjen S. Parman, Jakarta',
                'email' => 'info@harapankita.co.id',
                'telepon' => '021-7654321'
            ],
            [
                'nama_rumah_sakit' => 'RS Cipto Mangunkusumo',
                'alamat' => 'Jl. Diponegoro No. 71, Jakarta',
                'email' => 'info@rscm.co.id',
                'telepon' => '021-3456789'
            ]
        ];

        foreach ($hospitals as $hospital) {
            Hospital::create($hospital);
        }
    }
}