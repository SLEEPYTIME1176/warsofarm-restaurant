<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Reservasi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== PENDAPATAN =====
        $pendapatanHariIni = Order::whereDate('created_at', today())
            ->whereIn('status', ['process', 'done'])
            ->sum('total');

        $pendapatanBulanIni = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereIn('status', ['process', 'done'])
            ->sum('total');

        $pendapatanTotal = Order::whereIn('status', ['process', 'done'])->sum('total');

        // ===== STATS =====
        $totalPesanan = Order::count();
        $pesananPending = Order::where('status', 'pending')->count();
        $pesananProcess = Order::where('status', 'process')->count();
        $pesananDone = Order::where('status', 'done')->count();
        $pesananCancelled = Order::where('status', 'cancelled')->count();

        $totalMenu = Produk::count();
        $totalKategori = Kategori::count();
        $totalUser = User::count();
        $reservasiPending = Reservasi::where('status', 'pending')->count();

        // ===== PESANAN TERBARU =====
        $pesananTerbaru = Order::with(['user', 'items'])
            ->latest()
            ->take(8)
            ->get();

        // ===== RESERVASI TERBARU =====
        $reservasiTerbaru = Reservasi::latest()->take(5)->get();

        // ===== GRAFIK 7 HARI TERAKHIR =====
        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartData[] = Order::whereDate('created_at', $date)
                ->whereIn('status', ['process', 'done'])
                ->sum('total');
        }

        // ===== TOP MENU (paling banyak dipesan) =====
        $topMenu = OrderItem::select('nama_produk', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('nama_produk')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'pendapatanHariIni',
            'pendapatanBulanIni',
            'pendapatanTotal',
            'totalPesanan',
            'pesananPending',
            'pesananProcess',
            'pesananDone',
            'pesananCancelled',
            'totalMenu',
            'totalKategori',
            'totalUser',
            'reservasiPending',
            'pesananTerbaru',
            'reservasiTerbaru',
            'chartLabels',
            'chartData',
            'topMenu'
        ));
    }
}