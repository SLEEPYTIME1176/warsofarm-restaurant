<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        // Ringkasan Reservasi
        $totalReservasi = Reservasi::count();
        $pending = Reservasi::where('status', 'pending')->count();
        $confirmed = Reservasi::where('status', 'confirmed')->count();
        $cancelled = Reservasi::where('status', 'cancelled')->count();

        // Reservasi bulan ini
        $bulanIni = Reservasi::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Data menu
        $totalMenu = Produk::count();
        $menuPopuler = Produk::where('is_popular', true)->count();
        $totalKategori = Kategori::count();

        // 5 Reservasi terbaru
        $recentReservasi = Reservasi::latest()->take(8)->get();

        // Reservasi per status (untuk chart sederhana)
        $statusData = [
            'Pending' => $pending,
            'Confirmed' => $confirmed,
            'Cancelled' => $cancelled,
        ];

        return view('admin.laporan.index', compact(
            'totalReservasi',
            'pending',
            'confirmed',
            'cancelled',
            'bulanIni',
            'totalMenu',
            'menuPopuler',
            'totalKategori',
            'recentReservasi',
            'statusData'
        ));
    }
}