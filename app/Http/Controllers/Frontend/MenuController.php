<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;

class MenuController extends Controller
{
    public function index()
{
    $kategoris = \App\Models\Kategori::with(['produks' => function ($q) {
        $q->orderBy('nama_produk');
    }])->get();

    $produks = \App\Models\Produk::with('kategori')->latest()->get();

    return view('pages.menu', compact('kategoris', 'produks'));
}

    public function show($slug)
{
    $produk = \App\Models\Produk::where('slug', $slug)->with('kategori')->firstOrFail();
    
    // Produk terkait (dari kategori yang sama)
    $terkait = \App\Models\Produk::where('kategori_id', $produk->kategori_id)
        ->where('id', '!=', $produk->id)
        ->take(4)
        ->get();

    return view('pages.detail', compact('produk', 'terkait'));
}
}