<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::insert([
            [
                'nama' => 'PT Indofood Sukses Makmur Tbk',
                'alamat' => 'Jl. Jend. Sudirman Kav. 76-78, Jakarta',
                'telepon' => '02157958822',
                'email' => 'info@indofood.com',
            ],
            [
                'nama' => 'PT Kalbe Farma Tbk',
                'alamat' => 'Jl. Let. Jend. Suprapto Kav. 4, Jakarta',
                'telepon' => '02142876800',
                'email' => 'info@kalbe.co.id',
            ],
            [
                'nama' => 'PT Mayora Indah Tbk',
                'alamat' => 'Jl. Daan Mogot KM 18, Jakarta',
                'telepon' => '02180637788',
                'email' => 'info@mayora.co.id',
            ],
        ]);
    }
}
