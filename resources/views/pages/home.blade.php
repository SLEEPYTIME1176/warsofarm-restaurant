@extends('layouts.app')

@section('content')

<!-- HERO COZY -->
<section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Selamat Datang di<br><span>Warso Restaurant</span></h1>
        <p>Pengalaman kuliner Nusantara dengan sentuhan modern dan kehangatan tradisional.</p>
        <div class="hero-buttons">
            <a href="/menu" class="btn btn-primary">Lihat Menu</a>
            <a href="/reservasi" class="btn btn-outline">Reservasi Meja</a>
        </div>
    </div>
</section>

<!-- WELCOME -->
<section class="section section-welcome">
    <div class="container">
        <h2>Nikmati Kehangatan Rumah</h2>
        <p>Setiap hidangan kami dibuat dengan cinta, bahan segar, dan resep turun temurun.</p>
    </div>
</section>

<!-- MENU POPULER -->
<section class="section section-menu">
    <div class="container">
        <div class="section-header">
            <h2>Menu Populer</h2>
            <p>Hidangan favorit pelanggan kami</p>
        </div>

        <div class="menu-grid">
            @forelse($popular as $item)
    <div class="menu-card">
        <a href="{{ route('menu.show', $item->slug) }}" style="text-decoration: none; color: inherit;">
            <div class="menu-card-img">
                <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=600&q=80' }}" 
                     alt="{{ $item->nama_produk }}">
            </div>
            <div class="menu-card-body">
                <h3>{{ $item->nama_produk }}</h3>
                <p>{{ $item->deskripsi }}</p>
            </div>
        </a>

        <div class="menu-card-body" style="padding-top: 0;">
            <div class="menu-card-footer">
                <span class="price">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                <button onclick="addToCart({{ $item->id }}, '{{ $item->nama_produk }}', {{ $item->harga }}, '{{ $item->foto ? asset('storage/'.$item->foto) : 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=600&q=80' }}')" 
                        class="btn btn-primary btn-sm">
                    Pesan
                </button>
            </div>
        </div>
    </div>
@empty
    <p style="text-align:center; grid-column: 1/-1;">Belum ada menu populer.</p>
@endforelse
        </div>
    </div>
</section>

<script>
function addToCart(id, name, price, image) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existing = cart.find(i => i.id === id);
    if (existing) existing.qty += 1;
    else cart.push({id, name, price, image, qty: 1});
    
    localStorage.setItem('cart', JSON.stringify(cart));
    alert(name + " ditambahkan ke keranjang!");
    
    const count = cart.reduce((a, b) => a + b.qty, 0);
    const badge = document.getElementById('cart-count');
    if (badge) badge.textContent = count;
}
</script>

@endsection