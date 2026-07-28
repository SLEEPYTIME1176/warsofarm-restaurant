<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $makanan = Kategori::where('nama_kategori', 'Makanan Utama')->first();

        $produks = [
            [
                'nama_produk' => 'Nasi Goreng Special',
                'deskripsi' => 'Nasi goreng dengan ayam, udang, dan telor mata sapi',
                'harga' => 28000,
                'stok' => 50,
                'is_popular' => true,
            ],
            [
                'nama_produk' => 'Sate Ayam Madura',
                'deskripsi' => 'Sate ayam dengan bumbu kacang spesial',
                'harga' => 35000,
                'stok' => 40,
                'is_popular' => true,
            ],
            [
                'nama_produk' => 'Soto Ayam',
                'deskripsi' => 'Soto ayam kuah kuning hangat',
                'harga' => 25000,
                'stok' => 30,
                'is_popular' => true,
            ],
            [
                'nama_produk' => 'Ayam Bakar',
                'deskripsi' => 'Ayam bakar bumbu kecap manis',
                'harga' => 32000,
                'stok' => 25,
                'is_popular' => true,
            ],
        ];

        foreach ($produks as $item) {
            Produk::create([
                'kategori_id' => $makanan->id,
                'nama_produk' => $item['nama_produk'],
                'slug' => Str::slug($item['nama_produk']),
                'deskripsi' => $item['deskripsi'],
                'harga' => $item['harga'],
                'stok' => $item['stok'],
                'is_popular' => $item['is_popular'],
                'foto' => null,
            ]);
        }
    }
}