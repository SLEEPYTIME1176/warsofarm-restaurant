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
}