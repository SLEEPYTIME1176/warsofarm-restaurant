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
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update(['status' => $request->status]);

        return redirect()->route('admin.reservasi.index')->with('success', 'Status reservasi berhasil diubah');
    }

    public function destroy($id)
    {
        Reservasi::findOrFail($id)->delete();
        return redirect()->route('admin.reservasi.index')->with('success', 'Reservasi berhasil dihapus');
    }
}