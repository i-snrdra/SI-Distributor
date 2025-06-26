<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Supplier;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = Supplier::all();
        $products = [
            // Indofood
            [
                'supplier' => 'PT Indofood Sukses Makmur Tbk',
                'items' => [
                    ['nama' => 'Indomie Goreng', 'stok' => 100, 'satuan' => 'bungkus', 'harga_beli' => 2500, 'harga_jual' => 3000],
                    ['nama' => 'Pop Mie Ayam', 'stok' => 80, 'satuan' => 'cup', 'harga_beli' => 4000, 'harga_jual' => 5000],
                    ['nama' => 'Chitato Sapi Panggang', 'stok' => 60, 'satuan' => 'bungkus', 'harga_beli' => 7000, 'harga_jual' => 8500],
                    ['nama' => 'Indomilk Susu Kental Manis', 'stok' => 50, 'satuan' => 'kaleng', 'harga_beli' => 9000, 'harga_jual' => 11000],
                    ['nama' => 'Supermi Soto', 'stok' => 70, 'satuan' => 'bungkus', 'harga_beli' => 2200, 'harga_jual' => 2700],
                ]
            ],
            // Kalbe Farma
            [
                'supplier' => 'PT Kalbe Farma Tbk',
                'items' => [
                    ['nama' => 'Promag', 'stok' => 120, 'satuan' => 'strip', 'harga_beli' => 6000, 'harga_jual' => 7500],
                    ['nama' => 'Hydro Coco', 'stok' => 90, 'satuan' => 'botol', 'harga_beli' => 8000, 'harga_jual' => 9500],
                    ['nama' => 'Fatigon', 'stok' => 100, 'satuan' => 'strip', 'harga_beli' => 7000, 'harga_jual' => 8500],
                    ['nama' => 'Woods Lozenges', 'stok' => 60, 'satuan' => 'box', 'harga_beli' => 12000, 'harga_jual' => 14000],
                    ['nama' => 'Extra Joss', 'stok' => 200, 'satuan' => 'sachet', 'harga_beli' => 1000, 'harga_jual' => 1500],
                ]
            ],
            // Mayora Indah
            [
                'supplier' => 'PT Mayora Indah Tbk',
                'items' => [
                    ['nama' => 'Kopiko', 'stok' => 150, 'satuan' => 'bungkus', 'harga_beli' => 5000, 'harga_jual' => 6500],
                    ['nama' => 'Beng Beng', 'stok' => 130, 'satuan' => 'bungkus', 'harga_beli' => 2000, 'harga_jual' => 2500],
                    ['nama' => 'Astor', 'stok' => 90, 'satuan' => 'box', 'harga_beli' => 8000, 'harga_jual' => 10000],
                    ['nama' => 'Roma Kelapa', 'stok' => 110, 'satuan' => 'bungkus', 'harga_beli' => 7000, 'harga_jual' => 9000],
                    ['nama' => 'Slai O Lai', 'stok' => 70, 'satuan' => 'bungkus', 'harga_beli' => 4000, 'harga_jual' => 5000],
                ]
            ],
        ];
        foreach ($products as $group) {
            $supplier = $suppliers->where('nama', $group['supplier'])->first();
            if ($supplier) {
                foreach ($group['items'] as $item) {
                    Product::create(array_merge($item, ['supplier_id' => $supplier->id]));
                }
            }
        }
    }
}
