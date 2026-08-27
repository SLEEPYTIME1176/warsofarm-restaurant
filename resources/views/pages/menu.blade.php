@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 50px; padding-bottom: 80px;">

    <div class="section-header">
        <h2>Daftar Menu</h2>
        <p>Pilih hidangan favoritmu</p>
    </div>

    {{-- Search --}}
<div class="menu-search-wrap">
    <input type="text"
           id="menuSearch"
           placeholder="Cari menu... (contoh: es teh)"
           autocomplete="off">
    <span class="menu-search-icon">🔍</span>
</div>

    {{-- FILTER KATEGORI --}}
<div class="filter-wrapper">
    <button onclick="filterKategori('semua')" class="filter-btn active" data-kat="semua">
        Semua
    </button>
    @foreach($kategoris as $kat)
        <button onclick="filterKategori('{{ $kat->id }}')" class="filter-btn" data-kat="{{ $kat->id }}">
            {{ $kat->nama_kategori }}
        </button>
    @endforeach
</div>

    {{-- GRID MENU --}}
    <div class="menu-grid" id="menuGrid">
        @forelse($produks as $item)
    <div class="menu-card {{ ($item->stok ?? 0) <= 0 ? 'menu-card--habis' : '' }}"
     data-kategori="{{ $item->kategori_id }}"
     data-name="{{ strtolower($item->nama_produk) }}">

    <a href="{{ route('menu.show', $item->slug) }}" style="text-decoration:none; color:inherit;">
        <div class="menu-card-img" style="position:relative;">
            <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=600&q=80' }}"
                 alt="{{ $item->nama_produk }}">

            @if(($item->stok ?? 0) <= 0)
                <span class="badge-habis">Stok Habis</span>
            @elseif($item->badge === 'terlaris')
                <span class="menu-badge badge-terlaris">🔥 Terlaris</span>
            @elseif($item->badge === 'favorit')
                <span class="menu-badge badge-favorit">⭐ Favorit</span>
            @elseif($item->badge === 'baru')
                <span class="menu-badge badge-baru">🆕 Baru</span>
            @endif
        </div>
    </a>

    <div class="menu-card-body">
        <h3>{{ $item->nama_produk }}</h3>
        <p>{{ Str::limit($item->deskripsi, 90) }}</p>

        <div class="menu-card-footer">
            <span class="price">
                Rp {{ number_format($item->harga, 0, ',', '.') }}
                <small style="font-size:12px; color:#8b7355;">/{{ $item->satuan ?? 'porsi' }}</small>
            </span>

            @if(($item->stok ?? 0) <= 0)
                <button type="button" class="btn btn-sm" disabled
                        style="background:#ddd; color:#888; cursor:not-allowed; border:none; padding:8px 14px; border-radius:10px;">
                    Habis
                </button>
            @else
                <button type="button"
                        onclick="addToCart({{ $item->id }}, '{{ addslashes($item->nama_produk) }}', {{ $item->harga }}, '{{ $item->foto ? asset('storage/'.$item->foto) : 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=600&q=80' }}')"
                        class="btn btn-primary btn-sm">
                    Tambah
                </button>
            @endif
        </div>

        @if(($item->stok ?? 0) > 0 && ($item->stok ?? 0) <= 5)
            <p style="margin:8px 0 0; font-size:12px; color:#e67e22;">Sisa {{ $item->stok }}</p>
        @endif
    </div>
</div>
@empty
    <p style="text-align:center; grid-column:1/-1;">Belum ada menu.</p>
@endforelse
    </div>
</div>

<style>
.filter-btn {
    padding: 9px 20px;
    border-radius: 999px;
    border: 1px solid #e8ddd0;
    background: transparent;
    color: #6b5244;
    font-size: 13.5px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    letter-spacing: 0.01em;
}

.filter-btn:hover {
    border-color: #9c5638;
    color: #9c5638;
    background: rgba(156, 86, 56, 0.06);
}

.filter-btn.active {
    background: #9c5638;
    color: #fff;
    border-color: #9c5638;
    box-shadow: 0 4px 14px rgba(156, 86, 56, 0.25);
}

/* Container tombol */
.filter-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    justify-content: center;
    margin-bottom: 48px;
    padding: 0 12px;
}
</style>

<script>
function filterKategori(katId) {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.kat == katId || (katId === 'semua' && btn.dataset.kat === 'semua'));
    });

    document.querySelectorAll('.menu-card').forEach(card => {
        if (katId === 'semua' || card.dataset.kategori == katId) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}

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

document.getElementById('menuSearch')?.addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    document.querySelectorAll('.menu-card').forEach(card => {
        const name = card.dataset.name || '';
        const matchSearch = name.includes(q);
        // hormati filter kategori yang aktif
        const activeKat = document.querySelector('.filter-btn.active')?.dataset.kat;
        const matchKat = !activeKat || activeKat === 'semua' || card.dataset.kategori == activeKat;
        card.style.display = (matchSearch && matchKat) ? '' : 'none';
    });
});
</script>
@endsection