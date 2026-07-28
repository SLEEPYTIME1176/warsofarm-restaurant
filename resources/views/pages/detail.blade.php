@extends('layouts.app')

@section('content')
<div class="container" style="padding: 60px 24px 80px;">
    
    <!-- Breadcrumb -->
    <div style="margin-bottom: 30px; font-size: 14px; color: #888;">
        <a href="/" style="color: #888;">Beranda</a> 
        <span style="margin: 0 8px;">/</span>
        <a href="{{ route('menu') }}" style="color: #888;">Menu</a>
        <span style="margin: 0 8px;">/</span>
        <span style="color: var(--primary);">{{ $produk->nama_produk }}</span>
    </div>

    <!-- Detail Produk -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: start; margin-bottom: 80px;">
        
        <!-- Gambar -->
        <div>
            <img src="{{ $produk->foto ? asset('storage/'.$produk->foto) : 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=800&q=80' }}" 
                 alt="{{ $produk->nama_produk }}"
                 style="width: 100%; border-radius: 24px; object-fit: cover; aspect-ratio: 1/1; box-shadow: 0 20px 50px rgba(90,55,30,0.12);">
        </div>

        <!-- Info -->
        <div>
            <span style="display: inline-block; background: #f8f1e9; color: var(--primary); padding: 6px 16px; border-radius: 50px; font-size: 13px; font-weight: 600; margin-bottom: 16px;">
                {{ $produk->kategori->nama_kategori ?? 'Menu' }}
            </span>

            <h1 style="font-family: 'Playfair Display', serif; font-size: 2.6rem; margin-bottom: 12px; line-height: 1.2;">
                {{ $produk->nama_produk }}
            </h1>

            <div style="font-size: 2rem; font-weight: 700; color: var(--primary); margin-bottom: 24px;">
                Rp {{ number_format($produk->harga, 0, ',', '.') }}
            </div>

            <p style="color: #6b5244; font-size: 1.05rem; line-height: 1.7; margin-bottom: 30px;">
                {{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}
            </p>

            <div style="display: flex; gap: 16px; align-items: center; margin-bottom: 20px;">
                <span style="color: #888; font-size: 14px;">Stok: <strong>{{ $produk->stok }}</strong></span>
                @if($produk->is_popular)
                    <span style="background: #e8b923; color: #3f2a20; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                        ⭐ Populer
                    </span>
                @endif
            </div>

            <button onclick="addToCart({{ $produk->id }}, '{{ $produk->nama_produk }}', {{ $produk->harga }}, '{{ $produk->foto ? asset('storage/'.$produk->foto) : 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=600&q=80' }}')" 
                    class="btn btn-primary" style="padding: 16px 40px; font-size: 16px;">
                + Tambah ke Keranjang
            </button>
        </div>
    </div>

    <!-- Produk Terkait -->
    @if($terkait->count() > 0)
        <div class="section-header" style="margin-bottom: 40px;">
            <h2>Menu Lainnya</h2>
            <p>Dari kategori yang sama</p>
        </div>

        <div class="menu-grid">
            @foreach($terkait as $item)
                <a href="{{ route('menu.show', $item->slug) }}" style="text-decoration: none; color: inherit;">
                    <div class="menu-card">
                        <div class="menu-card-img">
                            <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=600&q=80' }}" 
                                 alt="{{ $item->nama_produk }}">
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