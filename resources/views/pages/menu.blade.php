@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 60px; padding-bottom: 80px;">
    <div class="section-header">
        <h2>Daftar Menu</h2>
        <p>Pilih hidangan favoritmu</p>
    </div>

    <div class="menu-grid">
        @forelse($produks as $item)
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
                    Tambah
                </button>
            </div>
        </div>
    </div>
@empty
    <p style="text-align:center; grid-column: 1/-1;">Belum ada menu.</p>
@endforelse
    </div>
</div>

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