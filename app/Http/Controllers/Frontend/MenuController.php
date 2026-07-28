<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;

class MenuController extends Controller
{
    public function index()
    {
        $produks = Produk::with('kategori')->latest()->get();
        $kategoris = Kategori::all();

        return view('pages.menu', compact('produks', 'kategoris'));
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