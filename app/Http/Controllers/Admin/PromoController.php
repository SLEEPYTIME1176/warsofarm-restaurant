<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->get();
        return view('admin.promo.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.promo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:150',
            'kode_promo' => 'required|string|max:30|unique:promos',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:persen,nominal',
            'nilai' => 'required|integer|min:1',
            'min_pembelian' => 'nullable|integer|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'judul', 'kode_promo', 'deskripsi', 'tipe', 'nilai',
            'min_pembelian', 'tanggal_mulai', 'tanggal_selesai'
        ]);
        $data['is_active'] = $request->has('is_active');
        $data['min_pembelian'] = $request->min_pembelian ?? 0;

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('promos', 'public');
        }

        Promo::create($data);

        return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil ditambahkan');
    }

    public function edit($id)
    {
        $promo = Promo::findOrFail($id);
        return view('admin.promo.edit', compact('promo'));
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:150',
            'kode_promo' => 'required|string|max:30|unique:promos,kode_promo,' . $id,
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:persen,nominal',
            'nilai' => 'required|integer|min:1',
            'min_pembelian' => 'nullable|integer|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'judul', 'kode_promo', 'deskripsi', 'tipe', 'nilai',
            'min_pembelian', 'tanggal_mulai', 'tanggal_selesai'
        ]);
        $data['is_active'] = $request->has('is_active');
        $data['min_pembelian'] = $request->min_pembelian ?? 0;

        if ($request->hasFile('gambar')) {
            if ($promo->gambar && Storage::disk('public')->exists($promo->gambar)) {
                Storage::disk('public')->delete($promo->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('promos', 'public');
        }

        $promo->update($data);

        return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil diperbarui');
    }

    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        if ($promo->gambar && Storage::disk('public')->exists($promo->gambar)) {
            Storage::disk('public')->delete($promo->gambar);
        }
        $promo->delete();

        return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil dihapus');
    }
}