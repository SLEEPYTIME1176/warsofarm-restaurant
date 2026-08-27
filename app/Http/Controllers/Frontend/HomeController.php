<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Promo;

class HomeController extends Controller
{
    public function index()
    {
        $popular = Produk::where('is_popular', true)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $promos = Promo::where('is_active', 1)
            ->whereDate('tanggal_mulai', '<=', now()->toDateString())
            ->whereDate('tanggal_selesai', '>=', now()->toDateString())
            ->latest()
            ->get();

        return view('pages.home', compact('popular', 'promos'));
    }
}