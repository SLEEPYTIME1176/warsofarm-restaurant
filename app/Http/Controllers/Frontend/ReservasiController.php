<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index()
    {
        return view('pages.reservasi');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email',
            'telepon' => 'nullable|string|max:20',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required',
            'jumlah_orang' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ]);

        Reservasi::create([
            'user_id' => auth()->id(),
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'jumlah_orang' => $request->jumlah_orang,
            'catatan' => $request->catatan,
            'status' => 'pending',
        ]);

        return redirect()->route('reservasi')->with('success', 'Reservasi berhasil dikirim! Kami akan segera menghubungi Anda.');
    }

    public function riwayat()
    {
        $reservasis = Reservasi::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('pages.riwayat-reservasi', compact('reservasis'));
    }

    public function batal(Request $request, $id)
{
    $reservasi = \App\Models\Reservasi::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    // Hanya boleh batal jika masih pending
    if ($reservasi->status !== 'pending') {
        return back()->with('error', 'Reservasi tidak bisa dibatalkan karena sudah diproses.');
    }

    $request->validate([
        'alasan_batal' => 'required|string|max:255',
    ]);

    $reservasi->update([
        'status' => 'cancelled',
        'alasan_batal' => $request->alasan_batal,
    ]);

    return back()->with('success', 'Reservasi Anda telah dibatalkan. Semoga lain waktu bisa berkunjung ke Warso 🌿');
}
}