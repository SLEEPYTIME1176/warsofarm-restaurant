<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PromoController extends Controller
{
    public function show($id)
    {
        $promo = Promo::where('is_active', 1)->findOrFail($id);

        return view('pages.promo-detail', compact('promo'));
    }

    public function cek(Request $request)
{
    $request->validate([
        'kode' => 'required|string',
        'subtotal' => 'required|numeric|min:0',
    ]);

    $promo = Promo::where('kode_promo', $request->kode)
        ->where('is_active', 1)
        ->whereDate('tanggal_mulai', '<=', now()->toDateString())
        ->whereDate('tanggal_selesai', '>=', now()->toDateString())
        ->first();

    if (!$promo) {
        return response()->json([
            'ok' => false,
            'message' => 'Kode promo tidak valid atau sudah berakhir.',
        ]);
    }

    $subtotal = (int) $request->subtotal;

    if ($promo->min_pembelian > 0 && $subtotal < $promo->min_pembelian) {
        return response()->json([
            'ok' => false,
            'message' => 'Min. pembelian Rp ' . number_format($promo->min_pembelian, 0, ',', '.'),
        ]);
    }

    $diskon = $promo->tipe === 'persen'
        ? (int) floor($subtotal * $promo->nilai / 100)
        : (int) $promo->nilai;

    if ($diskon > $subtotal) {
        $diskon = $subtotal;
    }

    return response()->json([
        'ok' => true,
        'message' => 'Promo diterapkan!',
        'kode' => $promo->kode_promo,
        'diskon' => $diskon,
        'tipe' => $promo->tipe,
        'nilai' => $promo->nilai,
    ]);
}
}

