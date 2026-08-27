<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items')
            ->latest()
            ->get();

        return view('pages.riwayat', compact('orders'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'cart'               => 'required|string',
            'catatan'            => 'nullable|string|max:500',
            'tipe_pesanan'       => 'required|in:dine_in,takeaway',
            'nomor_meja'         => 'nullable|string|max:20',
            'metode_pembayaran'  => 'required|in:tunai,transfer,qris',
            'kode_promo'         => 'nullable|string|max:30',
            'diskon'             => 'nullable|integer|min:0',
        ]);

        if ($request->tipe_pesanan === 'dine_in' && empty($request->nomor_meja)) {
            return back()->with('error', 'Silakan pilih nomor meja untuk dine-in');
        }

        $cart = json_decode($request->cart, true);

        if (empty($cart) || !is_array($cart)) {
            return back()->with('error', 'Keranjang kosong');
        }

        // ===== CEK STOK TERBARU =====
        $stokError = [];

        foreach ($cart as $item) {
            $produkId = $item['id'] ?? null;
            $qty      = (int) ($item['qty'] ?? 1);
            $nama     = $item['name'] ?? 'Produk';

            if (!$produkId) {
                continue;
            }

            $produk = Produk::find($produkId);

            if (!$produk) {
                $stokError[] = "{$nama} tidak ditemukan.";
                continue;
            }

            if ($produk->stok <= 0) {
                $stokError[] = "{$produk->nama_produk} sudah habis.";
            } elseif ($qty > $produk->stok) {
                $stokError[] = "{$produk->nama_produk} hanya tersisa {$produk->stok} porsi (kamu pesan {$qty}).";
            }
        }

        if (count($stokError) > 0) {
            return back()->with('error', implode(' ', $stokError));
        }

        // ===== SUBTOTAL =====
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['price'] ?? 0) * ($item['qty'] ?? 1);
        }

        // ===== PROMO (hitung ulang di server) =====
        $kodePromo = null;
        $diskon    = 0;

        if ($request->filled('kode_promo')) {
            DB::transaction(function () use ($request, $subtotal, &$kodePromo, &$diskon) {
                $promo = Promo::where('kode_promo', $request->kode_promo)
                    ->where('is_active', 1)
                    ->whereDate('tanggal_mulai', '<=', now()->toDateString())
                    ->whereDate('tanggal_selesai', '>=', now()->toDateString())
                    ->lockForUpdate()
                    ->first();

                if (!$promo) {
                    return;
                }

                // Kuota habis
                if ($promo->kuota !== null && $promo->terpakai >= $promo->kuota) {
                    return;
                }

                // Min. belanja
                if ($promo->min_pembelian > 0 && $subtotal < $promo->min_pembelian) {
                    return;
                }

                $diskon = $promo->tipe === 'persen'
                    ? (int) floor($subtotal * $promo->nilai / 100)
                    : (int) $promo->nilai;

                if ($diskon > $subtotal) {
                    $diskon = $subtotal;
                }

                $kodePromo = $promo->kode_promo;
                $promo->increment('terpakai');
            });
        }

        $total = max(0, $subtotal - $diskon);

        // ===== SIMPAN ORDER =====
        $order = Order::create([
            'user_id'            => Auth::id(),
            'kode_order'         => 'WRS-' . strtoupper(Str::random(8)),
            'total'              => $total,
            'kode_promo'         => $kodePromo,
            'diskon'             => $diskon,
            'status'             => 'pending',
            'catatan'            => $request->catatan,
            'tipe_pesanan'       => $request->tipe_pesanan,
            'nomor_meja'         => $request->tipe_pesanan === 'dine_in' ? $request->nomor_meja : null,
            'metode_pembayaran'  => $request->metode_pembayaran,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'    => $order->id,
                'produk_id'   => $item['id'] ?? null,
                'nama_produk' => $item['name'] ?? 'Produk',
                'harga'       => $item['price'] ?? 0,
                'qty'         => $item['qty'] ?? 1,
                'subtotal'    => ($item['price'] ?? 0) * ($item['qty'] ?? 1),
            ]);
        }

        $msg = 'Pesanan berhasil! Kode: ' . $order->kode_order;
        if ($diskon > 0) {
            $msg .= ' (diskon Rp ' . number_format($diskon, 0, ',', '.') . ')';
        }
        $msg .= ' — Silakan datang ke lokasi.';

        return redirect()->route('riwayat')->with('success', $msg);
    }

    public function cancelByUser(Request $request, $id)
    {
        $request->validate([
            'alasan_batal' => 'required|string|max:255',
        ]);

        $order = Order::where('user_id', auth()->id())->findOrFail($id);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan tidak bisa dibatalkan.');
        }

        if (in_array($order->metode_pembayaran, ['transfer', 'qris'])) {
            return back()->with('error', 'Untuk pembayaran Transfer/QRIS, gunakan Ajukan Pembatalan.');
        }

        $order->update([
            'status'             => 'cancelled',
            'alasan_batal'       => $request->alasan_batal,
            'alasan_batal_user'  => $request->alasan_batal,
        ]);

        return back()->with('success', 'Pesanan ' . $order->kode_order . ' berhasil dibatalkan.');
    }

    public function requestCancel(Request $request, $id)
    {
        $request->validate([
            'alasan_batal' => 'required|string|max:255',
        ]);

        $order = Order::where('user_id', auth()->id())->findOrFail($id);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan tidak bisa diajukan pembatalan.');
        }

        $order->update([
            'cancel_request'    => true,
            'alasan_batal_user' => $request->alasan_batal,
        ]);

        return back()->with('success', 'Pengajuan pembatalan terkirim. Menunggu konfirmasi restoran.');
    }
}