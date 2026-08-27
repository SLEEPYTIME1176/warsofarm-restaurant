<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" href="{{ asset('frontend/img/favicon.jpeg') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Warso Restaurant</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#fffaf0]">

{{-- ===== NAVBAR ===== --}}
<nav class="navbar">
    <div class="nav-container">
        <a href="/" class="logo" style="display:flex; align-items:center; gap:10px; text-decoration:none;">
    <img src="/frontend/img/logo-warso.jpeg"
         alt="Warso"
         style="height:40px; width:auto; display:block;">
    <span style="font-family:'Playfair Display',serif; font-size:22px; font-weight:700; color:#9c5638;">
        Warso
    </span>
</a>
        <ul class="nav-menu">
            <li><a href="/">Beranda</a></li>
            <li><a href="{{ route('menu') }}">Menu</a></li>
            <li><a href="{{ route('paket') }}">Paket</a></li>
            <li><a href="{{ route('reservasi') }}">Reservasi</a></li>
            <li><a href="{{ route('lokasi') }}">Lokasi</a></li>
            <li><a href="{{ route('kontak') }}">Hubungi Kami</a></li>
        </ul>

        <div class="nav-right">
            <a href="{{ route('keranjang') }}" class="nav-icon-link">
                🛒 Keranjang
                <span id="cart-count" class="nav-badge">0</span>
            </a>

            @auth
                {{-- Dropdown Riwayat --}}
                <div class="nav-dropdown">
                    <button type="button" class="nav-icon-link nav-dropdown-trigger">
                        Riwayat
                        @php
                            $pendingCount = \App\Models\Order::where('user_id', auth()->id())
                                ->whereIn('status', ['pending', 'process'])
                                ->count();
                        @endphp
                        @if($pendingCount > 0)
                            <span class="nav-badge">{{ $pendingCount }}</span>
                        @endif
                        <span style="font-size:10px; margin-left:2px;">▾</span>
                    </button>
                    <div class="nav-dropdown-menu">
                        <a href="{{ route('riwayat') }}">🛒 Riwayat Pesanan</a>
                        <a href="{{ route('riwayat.reservasi') }}">📅 Riwayat Reservasi</a>
                    </div>
                </div>

                {{-- Profile Dropdown --}}
                <div class="profile-dropdown">
                    <button type="button" class="profile-trigger">
                        <span class="nav-avatar">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/'.auth()->user()->avatar) }}" alt="Avatar"
                                     style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                            @else
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            @endif
                        </span>
                        <span class="nav-username">{{ explode(' ', auth()->user()->name)[0] }}</span>
                        <span class="profile-chevron">▾</span>
                    </button>

                    <div class="profile-menu">
                        <div class="profile-menu-header">
                            <div class="profile-menu-name">{{ auth()->user()->name }}</div>
                            <div class="profile-menu-email">{{ auth()->user()->email }}</div>
                        </div>
                        <div class="profile-menu-divider"></div>
                        <a href="{{ route('profile.edit') }}" class="profile-menu-item">
                            <span>👤</span> Edit Profil
                        </a>
                        <a href="{{ route('riwayat') }}" class="profile-menu-item">
                            <span>📋</span> Pesanan Saya
                        </a>
                        <a href="{{ route('riwayat.reservasi') }}" class="profile-menu-item">
                            <span>📅</span> Reservasi Saya
                        </a>
                        <a href="{{ route('keranjang') }}" class="profile-menu-item">
                            <span>🛒</span> Keranjang
                        </a>
                        <div class="profile-menu-divider"></div>
                        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" class="profile-menu-item profile-menu-logout">
                                <span>🚪</span> Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="nav-logout">Masuk</a>
            @endauth
        </div>
    </div>
</nav>

{{-- ===== MAIN + FOOTER ===== --}}
<div class="site-wrapper">
    <main class="site-main">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="footer-logo">Warso</div>
                    <p>
                        Warso Restaurant — pengalaman kuliner Nusantara
                        dengan sentuhan modern dan kehangatan tradisional.
                    </p>
                </div>

                <div class="footer-col">
                    <h4>Navigasi</h4>
                    <a href="{{ url('/') }}">Beranda</a>
                    <a href="{{ route('menu') }}">Menu</a>
                    <a href="{{ route('paket') }}">Paket</a>
                    <a href="{{ route('reservasi') }}">Reservasi</a>
                    <a href="{{ route('lokasi') }}">Lokasi</a>
                </div>

                <div class="footer-col">
                    <h4>Kontak</h4>
                    <a href="tel:081367787355">0813-6778-7355</a>
                    <span>Jl. K.H. Halimi, Cipelang<br>Cijeruk, Bogor 16740</span>
                    <span>09.00 – 17.00 WIB</span>
                </div>

                <div class="footer-col">
                    <h4>Lainnya</h4>
                    <a href="{{ route('kontak') }}">Hubungi Kami</a>
                    <a href="https://www.google.com/maps/search/?api=1&query=Warso+Restaurant+Cijeruk+Bogor"
                       target="_blank" rel="noopener">Google Maps</a>
                    @auth
                        <a href="{{ route('riwayat') }}">Pesanan Saya</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                    @endauth
                </div>
            </div>

            <div class="footer-bottom">
                <span>© {{ date('Y') }} Warso Restaurant. All rights reserved.</span>
                <span>Bogor, Jawa Barat</span>
            </div>
        </div>
    </footer>
</div>

{{-- ===== TOAST ===== --}}
<div id="toast" style="
    position: fixed;
    bottom: 28px;
    right: 28px;
    z-index: 9999;
    min-width: 280px;
    max-width: 360px;
    background: #3f2a20;
    color: white;
    padding: 16px 20px;
    border-radius: 14px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.2);
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    font-weight: 500;
    transform: translateY(120px);
    opacity: 0;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    pointer-events: none;
">
    <span id="toast-icon" style="font-size:20px;">✓</span>
    <span id="toast-message">Berhasil</span>
</div>

{{-- ===== FLOATING BUTTONS ===== --}}
<div class="float-stack">
    <button type="button" class="float-btn float-ai" id="aiToggle" title="Asisten Warso AI">
        <span>🤖</span>
        <span class="float-label">Asisten AI</span>
    </button>
    <a href="https://wa.me/6281367787355?text=Halo%20Warso%2C%20saya%20ingin%20bertanya..."
       target="_blank"
       class="float-btn float-wa"
       title="Chat WhatsApp">
        <span>💬</span>
        <span class="float-label">WhatsApp</span>
    </a>
</div>

{{-- ===== PANEL CHAT AI ===== --}}
<div class="ai-panel" id="aiPanel">
    <div class="ai-header">
        <div>
            <strong>🤖 Asisten Warso</strong>
            <small>Online · Siap membantu</small>
        </div>
        <button type="button" id="aiClose">✕</button>
    </div>

    <div class="ai-messages" id="aiMessages">
        <div class="ai-bubble bot">
            Halo! 👋 Saya Asisten Warso.<br>
            Tanya saja tentang jam buka, lokasi, menu, paket, atau reservasi.
        </div>
    </div>

    <div class="ai-quick">
        <button type="button" data-q="jam buka">🕐 Jam buka</button>
        <button type="button" data-q="lokasi">📍 Lokasi</button>
        <button type="button" data-q="menu favorit">⭐ Menu favorit</button>
        <button type="button" data-q="paket">🎁 Paket</button>
        <button type="button" data-q="reservasi">📅 Reservasi</button>
        <button type="button" data-q="promo">🎉 Promo</button>
    </div>

    <div class="ai-input-wrap">
        <input type="text" id="aiInput" placeholder="Ketik pertanyaan..." autocomplete="off">
        <button type="button" id="aiSend">Kirim</button>
    </div>
</div>

<style>
/* Sticky layout */
html, body {
    height: 100%;
    margin: 0;
}
.site-wrapper {
    min-height: calc(100vh - 78px);
    display: flex;
    flex-direction: column;
}
.site-main {
    flex: 1 0 auto;
}

/* Footer */
.site-footer {
    background: #3f2a20;
    color: white;
    padding: 72px 24px 36px;
    margin-top: 48px;
    flex-shrink: 0;
}
.footer-inner {
    max-width: 1120px;
    margin: 0 auto;
}
.footer-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr 1.2fr 1fr;
    gap: 48px;
    margin-bottom: 56px;
}
.footer-logo {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 16px;
    letter-spacing: -0.5px;
}
.footer-brand p {
    font-size: 15px;
    line-height: 1.75;
    opacity: 0.7;
    max-width: 280px;
}
.footer-col h4 {
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 20px;
    opacity: 0.95;
}
.footer-col a,
.footer-col span {
    display: block;
    font-size: 14.5px;
    color: rgba(255,255,255,0.65);
    text-decoration: none;
    margin-bottom: 12px;
    line-height: 1.5;
    transition: all 0.25s ease;
}
.footer-col a:hover {
    color: #f4d35e;
    transform: translateX(4px);
}
.footer-bottom {
    border-top: 1px solid rgba(255,255,255,0.12);
    padding-top: 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    font-size: 13.5px;
    color: rgba(255,255,255,0.45);
}
@media (max-width: 900px) {
    .footer-grid { grid-template-columns: 1fr 1fr; gap: 36px; }
}
@media (max-width: 520px) {
    .footer-grid { grid-template-columns: 1fr; gap: 32px; }
    .site-footer { padding: 56px 20px 28px; }
}

/* Nav dropdown */
.nav-dropdown {
    position: relative;
    display: inline-block;
}
.nav-dropdown-trigger {
    background: none;
    border: none;
    cursor: pointer;
    font-family: inherit;
    font-size: inherit;
    color: inherit;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.nav-dropdown-menu {
    display: none;
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    background: white;
    border: 1px solid #f0e6d8;
    border-radius: 12px;
    min-width: 200px;
    box-shadow: 0 10px 28px rgba(63,42,32,0.12);
    z-index: 200;
    padding: 6px 0;
    overflow: hidden;
}
.nav-dropdown-menu.open { display: block; }
.nav-dropdown-menu a {
    display: block;
    padding: 11px 16px;
    color: #3f2a20;
    text-decoration: none;
    font-size: 13.5px;
    transition: background 0.15s;
}
.nav-dropdown-menu a:hover { background: #fff8f0; }

/* Floating buttons */
.float-stack {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 900;
    display: flex;
    flex-direction: column;
    gap: 10px;
    align-items: flex-end;
}
.float-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 16px;
    border-radius: 50px;
    border: none;
    color: white;
    font-weight: 600;
    font-size: 13.5px;
    cursor: pointer;
    text-decoration: none;
    box-shadow: 0 8px 24px rgba(0,0,0,0.18);
    transition: transform 0.2s, box-shadow 0.2s;
    font-family: inherit;
}
.float-btn:hover { transform: translateY(-2px); }
.float-ai { background: #3f2a20; }
.float-wa { background: #25D366; }

/* AI panel */
.ai-panel {
    position: fixed;
    bottom: 100px;
    right: 24px;
    width: 360px;
    max-width: calc(100vw - 32px);
    height: 480px;
    max-height: calc(100vh - 140px);
    background: white;
    border-radius: 20px;
    box-shadow: 0 16px 48px rgba(63,42,32,0.2);
    display: none;
    flex-direction: column;
    z-index: 1000;
    overflow: hidden;
    border: 1px solid #f0e6d8;
}
.ai-panel.open { display: flex; }
.ai-header {
    background: #3f2a20;
    color: white;
    padding: 14px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.ai-header strong { display: block; font-size: 14.5px; }
.ai-header small { opacity: 0.75; font-size: 11.5px; }
.ai-header button {
    background: none; border: none; color: white;
    font-size: 18px; cursor: pointer; line-height: 1;
}
.ai-messages {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
    background: #fffaf5;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.ai-bubble {
    max-width: 85%;
    padding: 10px 14px;
    border-radius: 14px;
    font-size: 13.5px;
    line-height: 1.5;
}
.ai-bubble.bot {
    background: white;
    color: #3f2a20;
    align-self: flex-start;
    border: 1px solid #f0e6d8;
    border-bottom-left-radius: 4px;
}
.ai-bubble.user {
    background: #9c5638;
    color: white;
    align-self: flex-end;
    border-bottom-right-radius: 4px;
}
.ai-quick {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    padding: 10px 12px;
    border-top: 1px solid #f0e6d8;
    background: white;
}
.ai-quick button {
    border: 1px solid #e8ddd0;
    background: #fffaf5;
    color: #5c4033;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 12px;
    cursor: pointer;
    font-family: inherit;
}
.ai-input-wrap {
    display: flex;
    gap: 8px;
    padding: 12px;
    border-top: 1px solid #f0e6d8;
    background: white;
}
.ai-input-wrap input {
    flex: 1;
    border: 1.5px solid #e8ddd0;
    border-radius: 12px;
    padding: 10px 12px;
    font-size: 13.5px;
    font-family: inherit;
}
.ai-input-wrap button {
    background: #9c5638;
    color: white;
    border: none;
    border-radius: 12px;
    padding: 0 16px;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
}
@media (max-width: 480px) {
    .float-label { display: none; }
    .float-btn { padding: 14px; border-radius: 50%; }
    .ai-panel { right: 12px; bottom: 90px; width: calc(100vw - 24px); }
}
</style>

<script>
/* Toast */
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const icon = document.getElementById('toast-icon');
    const msg = document.getElementById('toast-message');
    if (!toast) return;

    msg.textContent = message;
    if (type === 'success') {
        toast.style.background = '#3f2a20';
        icon.textContent = '✓';
    } else if (type === 'error') {
        toast.style.background = '#c0392b';
        icon.textContent = '!';
    } else {
        toast.style.background = '#9c5638';
        icon.textContent = '🛒';
    }

    toast.style.transform = 'translateY(0)';
    toast.style.opacity = '1';
    clearTimeout(window.__toastTimer);
    window.__toastTimer = setTimeout(() => {
        toast.style.transform = 'translateY(120px)';
        toast.style.opacity = '0';
    }, 2500);
}

/* Cart global */
function addToCart(id, name, price, image) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existing = cart.find(i => i.id === id);
    if (existing) existing.qty += 1;
    else cart.push({ id, name, price, image, qty: 1 });

    localStorage.setItem('cart', JSON.stringify(cart));
    const count = cart.reduce((a, b) => a + b.qty, 0);
    const badge = document.getElementById('cart-count');
    if (badge) badge.textContent = count;
    showToast(name + ' ditambahkan ke keranjang', 'cart');
}

/* Update badge on load */
document.addEventListener('DOMContentLoaded', function () {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const count = cart.reduce((a, b) => a + b.qty, 0);
    const badge = document.getElementById('cart-count');
    if (badge) badge.textContent = count;
});

/* Nav dropdown */
document.querySelectorAll('.nav-dropdown-trigger').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const menu = this.nextElementSibling;
        document.querySelectorAll('.nav-dropdown-menu.open').forEach(m => {
            if (m !== menu) m.classList.remove('open');
        });
        menu.classList.toggle('open');
    });
});
document.addEventListener('click', () => {
    document.querySelectorAll('.nav-dropdown-menu.open').forEach(m => m.classList.remove('open'));
});

/* AI Chatbot */
(function () {
    const panel = document.getElementById('aiPanel');
    const messages = document.getElementById('aiMessages');
    const input = document.getElementById('aiInput');

    document.getElementById('aiToggle')?.addEventListener('click', () => {
        panel.classList.toggle('open');
        if (panel.classList.contains('open')) input.focus();
    });
    document.getElementById('aiClose')?.addEventListener('click', () => {
        panel.classList.remove('open');
    });

    function getReply(text) {
        const q = text.toLowerCase().trim();
        if (/jam|buka|tutup|operasional/.test(q))
            return 'Warso buka setiap hari Senin–Minggu pukul <strong>09.00–17.00 WIB</strong>. 🌿';
        if (/lokasi|alamat|mana|maps|dimana|di mana/.test(q))
            return 'Lokasi kami:<br><strong>Jl. K.H. Halimi, Cipelang, Cijeruk, Kabupaten Bogor, Jawa Barat 16740</strong>.<br><a href="https://maps.google.com/?q=Warso+Restaurant+Cijeruk" target="_blank" style="color:#9c5638;">Buka di Google Maps →</a>';
        if (/favorit|terlaris|rekomendasi|enak|menu favorit/.test(q))
            return 'Menu favorit ada di halaman <a href="/menu" style="color:#9c5638;">Menu</a> dengan badge 🔥 Terlaris / ⭐ Favorit. Cek juga Paket Spesial!';
        if (/paket|paketan|family|keluarga/.test(q))
            return 'Lihat <strong>Paket Spesial</strong> di halaman <a href="/paket" style="color:#9c5638;">Paket</a>.';
        if (/reservasi|booking|meja|pesan tempat/.test(q))
            return 'Isi form di halaman <a href="/reservasi" style="color:#9c5638;">Reservasi</a>. Untuk rombongan besar, reservasi dulu ya.';
        if (/promo|diskon|voucher|hemat/.test(q))
            return 'Cek promo di beranda atau tanya admin via WhatsApp 🎉';
        if (/halo|hai|hi|selamat|pagi|siang|sore/.test(q))
            return 'Halo! Ada yang bisa saya bantu? Tanya jam buka, lokasi, menu, paket, atau reservasi.';
        if (/terima kasih|makasih|thanks/.test(q))
            return 'Sama-sama! Selamat menikmati kunjungan di Warso 🌿';
        if (/wa|whatsapp|admin|manusia|cs|customer/.test(q))
            return 'Klik tombol <strong>WhatsApp</strong> hijau di pojok kanan bawah, atau <a href="https://wa.me/6281367787355" target="_blank" style="color:#25D366;">chat di sini</a>.';
        return 'Maaf, saya belum paham 🙏<br>Coba tanya: <em>jam buka, lokasi, menu, paket, reservasi, promo</em>. Atau chat admin via WhatsApp.';
    }

    function addBubble(html, who) {
        const div = document.createElement('div');
        div.className = 'ai-bubble ' + who;
        div.innerHTML = html;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }

    function send() {
        const text = input.value.trim();
        if (!text) return;
        addBubble(text.replace(/</g, '&lt;'), 'user');
        input.value = '';
        setTimeout(() => addBubble(getReply(text), 'bot'), 350);
    }

    document.getElementById('aiSend')?.addEventListener('click', send);
    input?.addEventListener('keydown', e => { if (e.key === 'Enter') send(); });

    document.querySelectorAll('.ai-quick button').forEach(btn => {
        btn.addEventListener('click', () => {
            const q = btn.dataset.q;
            addBubble(q, 'user');
            setTimeout(() => addBubble(getReply(q), 'bot'), 350);
        });
    });
})();
</script>

</body>
</html>