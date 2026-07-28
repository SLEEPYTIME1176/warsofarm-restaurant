<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with('kategori')->latest()->get();
        return view('admin.produk.index', compact('produks'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'kategori_id' => 'required',
            'harga' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('produk', 'public');
        }

        Produk::create([
            'kategori_id' => $request->kategori_id,
            'nama_produk' => $request->nama_produk,
            'slug' => Str::slug($request->nama_produk),
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok ?? 0,
            'is_popular' => $request->has('is_popular'),
            'foto' => $fotoPath,
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nama_produk' => 'required',
        'kategori_id' => 'required',
        'harga' => 'required|numeric',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $produk = Produk::findOrFail($id);

    $data = [
        'kategori_id' => $request->kategori_id,
        'nama_produk' => $request->nama_produk,
        'slug' => Str::slug($request->nama_produk),
        'deskripsi' => $request->deskripsi,
        'harga' => $request->harga,
        'stok' => $request->stok ?? 0,
        'is_popular' => $request->has('is_popular'),
    ];

    // Hapus foto jika dicentang
    if ($request->has('hapus_foto') && $produk->foto) {
        if (Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }
        $data['foto'] = null;
    }

    // Upload foto baru
    if ($request->hasFile('foto')) {
        // Hapus foto lama dulu (jika masih ada)
        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }
        $data['foto'] = $request->file('foto')->store('produk', 'public');
    }

    $produk->update($data);

    return redirect()->route('admin.produk.index')->with('success', 'Menu berhasil diperbarui');
}

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Menu berhasil dihapus');
    }
}