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

{{-- STATISTIK --}}
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-num">8.900+</div>
                <div class="stat-label">Pengunjung Bahagia</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">50+</div>
                <div class="stat-label">Menu Spesial</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">4,3★</div>
                <div class="stat-label">Rating Google</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">2020</div>
                <div class="stat-label">Berdiri Sejak</div>
            </div>
        </div>
    </div>
</section>

{{-- KENAPA PILIH WARSO --}}
<section class="why-section">
    <div class="container">
        <div class="section-header">
            <h2>Kenapa Pilih Warso?</h2>
            <p>Alasan yang membuat banyak keluarga kembali lagi</p>
        </div>
        <div class="why-grid">
            <div class="why-card">
                <div class="why-icon">🌿</div>
                <h3>Bahan Segar</h3>
                <p>Dari kebun sendiri — durian, buah, dan hasil bumi lokal yang selalu segar.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">👨‍👩‍👧‍👦</div>
                <h3>Cocok Keluarga</h3>
                <p>Area luas, ramah anak, dan suasana hangat untuk berkumpul bersama.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">🎓</div>
                <h3>Tur Edukasi</h3>
                <p>Belajar sambil jalan-jalan di kebun durian & buah naga.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">⭐</div>
                <h3>Rating Tinggi</h3>
                <p>Dipercaya ribuan pengunjung dengan ulasan positif di Google Maps.</p>
            </div>
        </div>
    </div>
</section>

{{-- GALLERY --}}
<section class="gallery-section">
    <div class="container">
        <div class="section-header">
            <h2>Galeri Warso</h2>
            <p>Cuplikan keindahan & kelezatan kami</p>
        </div>
        <div class="gallery-grid">
    <div class="gallery-item">
        <img src="{{ asset('frontend/img/galeri-1.jpg') }}" alt="Galeri Warso 1">
    </div>
    <div class="gallery-item">
        <img src="{{ asset('frontend/img/galeri-2.jpg') }}" alt="Galeri Warso 2">
    </div>
    <div class="gallery-item">
        <img src="{{ asset('frontend/img/galeri-3.jpg') }}" alt="Galeri Warso 3">
    </div>
    <div class="gallery-item">
        <img src="{{ asset('frontend/img/galeri-4.jpg') }}" alt="Galeri Warso 4">
    </div>
    <div class="gallery-item">
        <img src="{{ asset('frontend/img/galeri-5.jpg') }}" alt="Galeri Warso 5">
    </div>
    <div class="gallery-item">
        <img src="{{ asset('frontend/img/galeri-6.jpg') }}" alt="Galeri Warso 6">
    </div>
</div>
    </div>
</section>

{{-- TESTIMONI --}}
<section class="testi-section">
    <div class="container">
        <div class="section-header">
            <h2>Kata Pengunjung</h2>
            <p>Cerita hangat dari yang sudah datang</p>
        </div>
        <div class="testi-grid">
            <div class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <p>“Tempatnya asri, makanannya enak, cocok banget bawa keluarga. Anak-anak senang lihat kebunnya.”</p>
                <div class="testi-author">— Rina, Jakarta</div>
            </div>
            <div class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <p>“Duriannya fresh, pelayanannya ramah. Worth the trip dari kota!”</p>
                <div class="testi-author">— Budi, Bogor</div>
            </div>
            <div class="testi-card">
                <div class="testi-stars">★★★★☆</div>
                <p>“Suasana tenang, makanan traditional tapi modern. Pasti balik lagi.”</p>
                <div class="testi-author">— Sari, Depok</div>
            </div>
        </div>
    </div>

{{-- FAQ --}}
<section class="faq-section">
    <div class="container">
        <div class="section-header">
            <h2>Pertanyaan Umum</h2>
            <p>Yang sering ditanyakan pengunjung</p>
        </div>
        <div class="faq-list">
            <details class="faq-item">
                <summary>Jam operasional Warso?</summary>
                <p>Setiap hari Senin–Minggu, pukul 09.00–17.00 WIB.</p>
            </details>
            <details class="faq-item">
                <summary>Apakah perlu reservasi?</summary>
                <p>Untuk rombongan besar disarankan reservasi. Individu/keluarga kecil bisa datang langsung.</p>
            </details>
            <details class="faq-item">
                <summary>Ada parkir?</summary>
                <p>Ya, tersedia area parkir luas untuk mobil dan motor.</p>
            </details>
            <details class="faq-item">
                <summary>Bisa pesan takeaway?</summary>
                <p>Bisa. Pilih Takeaway saat checkout, lalu ambil di lokasi.</p>
            </details>
            <details class="faq-item">
                <summary>Lokasi tepatnya di mana?</summary>
                <p>Jl. K.H. Halimi, Cipelang, Kec. Cijeruk, Kabupaten Bogor, Jawa Barat 16740.</p>
            </details>
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

@if(isset($promos) && $promos->count())
<section style="padding:48px 24px; background:#faf6f1;">
    <div style="max-width:1100px; margin:0 auto;">
        <div style="text-align:center; margin-bottom:28px;">
            <h2 style="font-size:28px; color:#3f2a20; margin:0 0 8px;">Promo Spesial</h2>
            <p style="color:#8b7355; margin:0; font-size:14px;">Gunakan kode promo saat memesan</p>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:18px;">
            @foreach($promos as $promo)
    @php
    $kuotaHabis = $promo->kuota !== null && ($promo->terpakai ?? 0) >= $promo->kuota;
@endphp

<a href="{{ route('promo.show', $promo->id) }}" class="promo-card-link" style="text-decoration:none; color:inherit; display:block;">
    <div class="promo-card" style="{{ $kuotaHabis ? 'opacity:0.65; filter:grayscale(0.4);' : '' }}">
        @if($promo->gambar)
            <div class="promo-card-img" style="position:relative;">
                <img src="{{ asset('storage/'.$promo->gambar) }}" alt="{{ $promo->judul }}">
                @if($kuotaHabis)
                    <span style="position:absolute; top:12px; left:12px; background:rgba(192,57,43,0.95); color:white; font-size:12px; font-weight:700; padding:5px 12px; border-radius:20px;">
                        Kuota Habis
                    </span>
                @endif
            </div>
        @endif
        <div class="promo-card-body">
            <h3>{{ $promo->judul }}</h3>
            @if($promo->deskripsi)
                <p>{{ $promo->deskripsi }}</p>
            @endif
            <div class="promo-card-meta">
                <span class="promo-kode">{{ $promo->kode_promo }}</span>
                <span class="promo-nilai">
                    @if($promo->tipe === 'persen')
                        {{ $promo->nilai }}% OFF
                    @else
                        Rp {{ number_format($promo->nilai, 0, ',', '.') }}
                    @endif
                </span>
            </div>
            <p class="promo-tanggal">
                s/d {{ \Carbon\Carbon::parse($promo->tanggal_selesai)->format('d M Y') }}
                @if($kuotaHabis)
                    <span style="color:#c0392b; font-weight:600;"> · Kuota habis</span>
                @endif
            </p>
        </div>
    </div>
</a>
@endforeach
        </div>
    </div>
</section>
@endif

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
    showToast(name + ' ditambahkan ke keranjang', 'cart');
    
    const count = cart.reduce((a, b) => a + b.qty, 0);
    const badge = document.getElementById('cart-count');
    if (badge) badge.textContent = count;
}
</script>

@endsection