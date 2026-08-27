<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index()
    {
        $reservasis = Reservasi::latest()->get();
        return view('admin.reservasi.index', compact('reservasis'));
    }

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,confirmed,done,cancelled',
        'alasan_batal' => 'nullable|string|max:255',
    ]);

    $reservasi = \App\Models\Reservasi::findOrFail($id);

    $data = ['status' => $request->status];

    // Simpan alasan hanya saat dibatalkan
    if ($request->status === 'cancelled') {
        $data['alasan_batal'] = $request->alasan_batal ?: 'Dibatalkan oleh admin';
    } else {
        $data['alasan_batal'] = null;
    }

    $reservasi->update($data);

    return back()->with('success', 'Status reservasi berhasil diubah');
}

    public function destroy($id)
    {
        Reservasi::findOrFail($id)->delete();
        return redirect()->route('admin.reservasi.index')->with('success', 'Reservasi berhasil dihapus');
    }
}