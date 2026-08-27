<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;

class PaketController extends Controller
{
    public function index()
    {
        // Cari kategori yang namanya mengandung "paket"
        $kategoriPaket = Kategori::where('nama_kategori', 'like', '%paket%')
            ->orWhere('nama_kategori', 'like', '%Paketan%')
            ->first();

        if ($kategoriPaket) {
            $pakets = Produk::where('kategori_id', $kategoriPaket->id)
                ->with('kategori')
                ->latest()
                ->get();
        } else {
            // fallback: ambil semua produk (kalau kategori belum ada)
            $pakets = collect();
        }

        return view('pages.paket', compact('pakets'));
    }
}