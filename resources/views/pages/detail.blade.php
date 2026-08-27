@extends('layouts.app')

@section('content')
<div class="container" style="padding: 60px 24px 80px;">

    {{-- Breadcrumb --}}
    <div style="margin-bottom: 30px; font-size: 14px; color: #888;">
        <a href="/" style="color: #888; text-decoration: none;">Beranda</a>
        <span style="margin: 0 8px;">/</span>
        <a href="{{ route('menu') }}" style="color: #888; text-decoration: none;">Menu</a>
        <span style="margin: 0 8px;">/</span>
        <span style="color: var(--primary);">{{ $produk->nama_produk }}</span>
    </div>

    {{-- Detail Produk --}}
    <div class="detail-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: start; margin-bottom: 80px;">

        {{-- Gambar --}}
        <div style="position: relative;">
            <img src="{{ $produk->foto ? asset('storage/'.$produk->foto) : 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=800&q=80' }}"
                 alt="{{ $produk->nama_produk }}"
                 style="width: 100%; border-radius: 24px; object-fit: cover; aspect-ratio: 1/1; box-shadow: 0 20px 50px rgba(90,55,30,0.12); {{ ($produk->stok ?? 0) <= 0 ? 'filter: grayscale(0.35);' : '' }}">

            @if(($produk->stok ?? 0) <= 0)
                <span style="position:absolute; top:20px; left:20px; background:rgba(192,57,43,0.95); color:white; font-size:13px; font-weight:700; padding:8px 16px; border-radius:20px;">
                    Stok Habis
                </span>
            @elseif(!empty($produk->badge))
                <span style="position:absolute; top:20px; left:20px; background:rgba(63,42,32,0.9); color:white; font-size:13px; font-weight:600; padding:8px 16px; border-radius:20px;">
                    @if($produk->badge === 'terlaris') 🔥 Terlaris
                    @elseif($produk->badge === 'favorit') ⭐ Favorit
                    @elseif($produk->badge === 'baru') 🆕 Baru
                    @endif
                </span>
            @endif
        </div>

        {{-- Info --}}
        <div>
            <span style="display: inline-block; background: #f8f1e9; color: var(--primary); padding: 6px 16px; border-radius: 50px; font-size: 13px; font-weight: 600; margin-bottom: 16px;">
                {{ $produk->kategori->nama_kategori ?? 'Menu' }}
            </span>

            <h1 style="font-family: 'Playfair Display', serif; font-size: 2.6rem; margin-bottom: 12px; line-height: 1.2; color: #3f2a20;">
                {{ $produk->nama_produk }}
            </h1>

            <div style="font-size: 2rem; font-weight: 700; color: var(--primary); margin-bottom: 8px;">
                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                <small style="font-size: 14px; font-weight: 500; color: #8b7355;">
                    /{{ $produk->satuan ?? 'porsi' }}
                </small>
            </div>

            {{-- Status stok --}}
            <div style="margin-bottom: 20px;">
                @if(($produk->stok ?? 0) <= 0)
                    <span style="color: #c0392b; font-size: 14px; font-weight: 600;">Stok Habis</span>
                @elseif(($produk->stok ?? 0) <= 5)
                    <span style="color: #e67e22; font-size: 14px; font-weight: 600;">
                        Sisa {{ $produk->stok }} {{ $produk->satuan ?? 'porsi' }}
                    </span>
                @else
                    <span style="color: #27ae60; font-size: 14px;">
                        Stok tersedia: <strong>{{ $produk->stok }}</strong>
                    </span>
                @endif

                @if($produk->is_popular)
                    <span style="margin-left: 10px; background: #e8b923; color: #3f2a20; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                        ⭐ Populer
                    </span>
                @endif
            </div>

            <p style="color: #6b5244; font-size: 1.05rem; line-height: 1.7; margin-bottom: 30px;">
                {{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}
            </p>

            {{-- Tombol --}}
            @if(($produk->stok ?? 0) <= 0)
                <button type="button" disabled
                        style="padding: 16px 40px; font-size: 16px; background: #ddd; color: #888; border: none; border-radius: 12px; cursor: not-allowed; font-family: inherit;">
                    Stok Habis
                </button>
            @else
                <button type="button"
                        onclick="addToCart({{ $produk->id }}, '{{ addslashes($produk->nama_produk) }}', {{ $produk->harga }}, '{{ $produk->foto ? asset('storage/'.$produk->foto) : 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=600&q=80' }}')"
                        class="btn btn-primary"
                        style="padding: 16px 40px; font-size: 16px;">
                    + Tambah ke Keranjang
                </button>
            @endif

            <div style="margin-top: 16px;">
                <a href="{{ route('menu') }}" style="color: #9c5638; font-size: 14px; text-decoration: none;">
                    ← Kembali ke Menu
                </a>
            </div>
        </div>
    </div>

    {{-- Produk Terkait --}}
    @if(isset($terkait) && $terkait->count() > 0)
        <div class="section-header" style="margin-bottom: 40px;">
            <h2>Menu Lainnya</h2>
            <p>Dari kategori yang sama</p>
        </div>

        <div class="menu-grid">
            @foreach($terkait as $item)
                <a href="{{ route('menu.show', $item->slug) }}" style="text-decoration: none; color: inherit;">
                    <div class="menu-card {{ ($item->stok ?? 0) <= 0 ? 'menu-card--habis' : '' }}">
                        <div class="menu-card-img" style="position: relative;">
                            <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=600&q=80' }}"
                                 alt="{{ $item->nama_produk }}"
                                 style="{{ ($item->stok ?? 0) <= 0 ? 'filter: grayscale(0.35);' : '' }}">

                            @if(($item->stok ?? 0) <= 0)
                                <span class="badge-habis">Stok Habis</span>
                            @endif
                        </div>
                        <div class="menu-card-body">
                            <h3>{{ $item->nama_produk }}</h3>
                            <p>{{ Str::limit($item->deskripsi, 50) }}</p>
                            <div class="menu-card-footer">
                                <span class="price">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>

<style>
@media (max-width: 768px) {
    .detail-grid {
        grid-template-columns: 1fr !important;
        gap: 28px !important;
    }
}
.badge-habis {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(192, 57, 43, 0.95);
    color: white;
    font-size: 12px;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 20px;
    z-index: 2;
}
.menu-card--habis {
    opacity: 0.75;
}
</style>

<script>
function addToCart(id, name, price, image) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existing = cart.find(i => i.id === id);
    if (existing) existing.qty += 1;
    else cart.push({ id, name, price, image, qty: 1 });

    localStorage.setItem('cart', JSON.stringify(cart));
    if (typeof showToast === 'function') {
        showToast(name + ' ditambahkan ke keranjang', 'cart');
    } else {
        alert(name + ' ditambahkan ke keranjang');
    }

    const count = cart.reduce((a, b) => a + b.qty, 0);
    const badge = document.getElementById('cart-count');
    if (badge) badge.textContent = count;
}
</script>
@endsection