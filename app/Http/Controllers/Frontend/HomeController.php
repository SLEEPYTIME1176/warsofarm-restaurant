<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Produk;

class HomeController extends Controller
{
    public function index()
    {
        $popular = Produk::where('is_popular', true)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('pages.home', compact('popular'));
    }
}