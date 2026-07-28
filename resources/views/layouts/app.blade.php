<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warso Restaurant</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#fffaf0]">

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="/" class="logo">Warso</a>
            
            <ul class="nav-menu">
                <li><a href="/">Beranda</a></li>
                <li><a href="/menu">Menu</a></li>
                <li><a href="/paket">Paket</a></li>
                <li><a href="/reservasi">Reservasi</a></li>
                <li><a href="/lokasi">Lokasi</a></li>
                <li><a href="/kontak">Hubungi Kami</a></li>
            </ul>

            {{-- Bagian kanan navbar --}}
<div style="display:flex; align-items:center; gap:8px;">

    {{-- Keranjang --}}
    <a href="{{ route('keranjang') }}" style="display:flex; align-items:center; gap:6px; padding:8px 14px; border-radius:50px; color:#5c4033; font-size:14px; font-weight:500; transition:background 0.2s;"
       onmouseover="this.style.background='#f8f1e9'" onmouseout="this.style.background='transparent'">
        <span style="font-size:16px;">🛒</span>
        Keranjang
        <span id="cart-count" style="background:#9c5638; color:white; font-size:11px; font-weight:600; padding:2px 7px; border-radius:20px; min-width:20px; text-align:center;">0</span>
    </a>

    @auth
        {{-- Divider --}}
        <div style="width:1px; height:24px; background:#e8ddd0; margin:0 4px;"></div>

        {{-- Riwayat --}}
        <a href="{{ route('riwayat') }}" style="padding:8px 12px; border-radius:50px; color:#5c4033; font-size:13.5px; font-weight:500; transition:background 0.2s;"
           onmouseover="this.style.background='#f8f1e9'" onmouseout="this.style.background='transparent'">
            Riwayat
        </a>

        {{-- Profil + Avatar --}}
        <a href="{{ route('profile.edit') }}" style="display:flex; align-items:center; gap:8px; padding:4px 10px 4px 4px; border-radius:50px; transition:background 0.2s; text-decoration:none;"
           onmouseover="this.style.background='#f8f1e9'" onmouseout="this.style.background='transparent'">
            <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=9c5638&color=fff&size=80&bold=true' }}"
                 alt="Avatar"
                 style="width:34px; height:34px; border-radius:50%; object-fit:cover; border:2px solid #f0e6d8;">
            <span style="font-size:13.5px; font-weight:600; color:#3f2a20; max-width:100px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                {{ Auth::user()->name }}
            </span>
        </a>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}" style="display:inline; margin:0;">
            @csrf
            <button type="submit" style="background:transparent; border:1.5px solid #e0d5c8; padding:7px 16px; border-radius:50px; cursor:pointer; font-size:13px; color:#5c4033; font-weight:500; transition:all 0.2s;"
                    onmouseover="this.style.borderColor='#9c5638'; this.style.color='#9c5638'" 
                    onmouseout="this.style.borderColor='#e0d5c8'; this.style.color='#5c4033'">
                Logout
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="btn btn-primary" style="padding:9px 22px; font-size:13.5px;">
            Masuk
        </a>
    @endauth
</div>
         </div>
    </nav>

    <!-- CONTENT -->
    @yield('content')

    <!-- FOOTER (sementara) -->
    <footer class="bg-[#3f2a20] text-white py-12 mt-20">
        <div class="max-w-6xl mx-auto text-center">
            <p class="text-2xl font-serif">Warso Restaurant</p>
            <p class="mt-2 opacity-70">Menyajikan kehangatan & kelezatan sejak 2026</p>
        </div>
    </footer>

</body>
</html>