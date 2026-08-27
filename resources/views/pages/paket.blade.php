@extends('layouts.app')

@section('content')
<div class="container" style="padding: 60px 24px 80px;">
    <div class="section-header">
        <h2>Paket Spesial</h2>
        <p>Pilihan paket lengkap untuk keluarga & acara</p>
    </div>

    <div class="menu-grid">
        @forelse($pakets as $item)
    <div class="menu-card">
        <a href="{{ route('menu.show', $item->slug) }}" style="text-decoration:none; color:inherit;">
            <div class="menu-card-img" style="position:relative;">
                @if($item->badge)
                    <span class="menu-badge badge-{{ $item->badge }}">
                        @if($item->badge === 'terlaris') 🔥 Terlaris
                        @elseif($item->badge === 'favorit') ⭐ Favorit
                        @elseif($item->badge === 'baru') 🆕 Baru
                        @endif
                    </span>
                @endif
                <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=600&q=80' }}"
                     alt="{{ $item->nama_produk }}">
            </div>
        </a>
        <div class="menu-card-body">
            <h3>{{ $item->nama_produk }}</h3>
            <p>{{ Str::limit($item->deskripsi, 90) }}</p>
            <div class="menu-card-footer">
                <span class="price">
                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                    <small style="font-size:12px; font-weight:500; color:#8b7355;">
                        /{{ $item->satuan ?? 'porsi' }}
                    </small>
                </span>
                <button onclick="event.preventDefault(); addToCart({{ $item->id }}, '{{ addslashes($item->nama_produk) }}', {{ $item->harga }}, '{{ $item->foto ? asset('storage/'.$item->foto) : 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=600&q=80' }}')"
                        class="btn btn-primary btn-sm">
                    Tambah
                </button>
            </div>
        </div>
    </div>
@empty
    <p style="text-align:center; grid-column:1/-1; color:#888; padding:60px 0;">
        Belum ada paket. Tambahkan produk dengan kategori <strong>Menu Paketan</strong> di admin.
    </p>
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
    showToast(name + ' ditambahkan ke keranjang', 'cart');

    const count = cart.reduce((a, b) => a + b.qty, 0);
    const badge = document.getElementById('cart-count');
    if (badge) badge.textContent = count;
}
</script>
@endsection