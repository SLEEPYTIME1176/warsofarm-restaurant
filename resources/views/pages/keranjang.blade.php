@extends('layouts.app')

@section('content')
<div class="container" style="padding: 60px 24px 80px; min-height: 55vh;">
    <div class="section-header">
        <h2>Keranjang Belanja</h2>
        <p>Periksa pesanan Anda sebelum checkout</p>
    </div>

    @guest
        <div class="cart-empty-box">
            <div style="font-size:40px; margin-bottom:12px;">🛒</div>
            <p style="margin-bottom:8px; font-weight:600; color:#3f2a20;">Silakan login dulu</p>
            <p style="margin-bottom:20px; color:#6b5244; font-size:14px;">Login diperlukan untuk melihat keranjang dan checkout</p>
            <a href="{{ route('login') }}" class="btn btn-primary">Login Sekarang</a>
        </div>
    @else
    @if(session('error'))
        <div style="max-width:720px; margin:0 auto 20px; background:#f8d7da; color:#721c24; padding:14px 18px; border-radius:12px; text-align:center;">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div style="max-width:720px; margin:0 auto 20px; background:#d4edda; color:#155724; padding:14px 18px; border-radius:12px; text-align:center;">
            {{ session('success') }}
        </div>
    @endif

    <div id="cart-items" class="cart-list"></div>

        <div id="cart-summary" class="cart-summary" style="display:none;">
            <div class="cart-summary-row">
                <span>Subtotal</span>
                <strong id="cart-total">Rp 0</strong>
            </div>

            {{-- Kode Promo --}}
<div style="margin-top:18px; padding-top:16px; border-top:1px solid #f0e6d8;">
    <label style="font-size:13px; font-weight:600; display:block; margin-bottom:8px;">Kode Promo</label>
    <div style="display:flex; gap:8px;">
        <input type="text" id="kode_promo" placeholder="Contoh: warso01"
               style="flex:1; padding:12px 14px; border:1.5px solid #e8ddd0; border-radius:12px; background:#fffaf5; font-size:14px; text-transform:uppercase;">
        <button type="button" onclick="terapkanPromo()"
                style="padding:12px 16px; background:#3f2a20; color:white; border:none; border-radius:12px; font-size:13px; cursor:pointer; white-space:nowrap;">
            Terapkan
        </button>
    </div>
    <p id="promo-msg" style="margin:8px 0 0; font-size:12.5px; color:#8b7355;"></p>
</div>

<div class="cart-summary-row" id="row-diskon" style="display:none; margin-top:12px; font-size:1rem;">
    <span style="color:#27ae60;">Diskon</span>
    <strong id="cart-diskon" style="color:#27ae60;">- Rp 0</strong>
</div>
<div class="cart-summary-row" style="margin-top:8px;">
    <span>Total</span>
    <strong id="cart-grand">Rp 0</strong>
</div>

            <div style="margin-top:24px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:10px;">Tipe Pesanan</label>
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <label class="tipe-option">
                        <input type="radio" name="tipe_pesanan" value="takeaway" checked onchange="toggleMeja()">
                        <span>🥡 Takeaway</span>
                    </label>
                    <label class="tipe-option">
                        <input type="radio" name="tipe_pesanan" value="dine_in" onchange="toggleMeja()">
                        <span>🍽️ Dine-in</span>
                    </label>
                </div>
            </div>

            <div id="meja-box" style="margin-top:16px; display:none;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:8px;">Pilih Meja</label>
                <select id="nomor_meja" style="width:100%; padding:12px; border:1.5px solid #e8ddd0; border-radius:12px; background:#fffaf5;">
                    <option value="">-- Pilih nomor meja --</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="Meja {{ $i }}">Meja {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div style="margin-top:20px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:10px;">Metode Pembayaran</label>
                <div style="display:flex; flex-direction:column; gap:8px;">
                    <label class="tipe-option">
                        <input type="radio" name="metode_pembayaran" value="tunai" checked>
                        <span>💵 Tunai di tempat</span>
                    </label>
                    <label class="tipe-option">
                        <input type="radio" name="metode_pembayaran" value="transfer">
                        <span>🏦 Transfer Bank</span>
                    </label>
                    <label class="tipe-option">
                        <input type="radio" name="metode_pembayaran" value="qris">
                        <span>📱 QRIS</span>
                    </label>
                </div>
            </div>

            <div style="margin-top:20px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:8px;">Catatan (opsional)</label>
                <textarea id="catatan" rows="2" placeholder="Contoh: Extra es, tanpa gula..."
                    style="width:100%; padding:12px 14px; border:1.5px solid #e8ddd0; border-radius:12px; background:#fffaf5; resize:none;"></textarea>
            </div>

            <button type="button" onclick="prosesCheckout()" class="btn btn-primary" style="width:100%; margin-top:20px; padding:16px; font-size:16px;">
                Checkout Sekarang
            </button>
        </div>
    @endguest
</div>

<style>
.cart-list {
    max-width: 720px;
    margin: 0 auto 28px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.cart-item {
    display: flex;
    gap: 20px;
    background: white;
    padding: 18px;
    border-radius: 18px;
    box-shadow: 0 8px 24px rgba(90, 55, 30, 0.07);
    align-items: center;
}
.cart-item img {
    width: 96px;
    height: 96px;
    object-fit: cover;
    border-radius: 14px;
    flex-shrink: 0;
}
.cart-item-info { flex: 1; min-width: 0; }
.cart-item-info h3 {
    font-size: 1.05rem;
    font-weight: 600;
    margin-bottom: 4px;
    color: #3f2a20;
}
.cart-item-info .price {
    color: #9c5638;
    font-weight: 700;
    margin-bottom: 12px;
}
.qty-control {
    display: flex;
    align-items: center;
    gap: 10px;
}
.qty-control button {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1.5px solid #e8ddd0;
    background: white;
    cursor: pointer;
    font-size: 16px;
    color: #5c4033;
}
.qty-control .remove-btn {
    width: auto;
    padding: 0 14px;
    border-radius: 20px;
    font-size: 12.5px;
    color: #c0392b;
    border-color: #f5c6cb;
    margin-left: 8px;
}
.cart-summary {
    max-width: 720px;
    margin: 0 auto;
    background: white;
    padding: 28px;
    border-radius: 20px;
    box-shadow: 0 12px 32px rgba(90, 55, 30, 0.08);
}
.cart-summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 1.25rem;
}
.cart-summary-row strong {
    color: #9c5638;
    font-size: 1.4rem;
}
.cart-empty-box {
    text-align: center;
    padding: 60px 24px;
    background: white;
    border-radius: 20px;
    max-width: 480px;
    margin: 0 auto;
    box-shadow: 0 8px 24px rgba(90, 55, 30, 0.06);
}
.tipe-option {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border: 1.5px solid #e8ddd0;
    border-radius: 12px;
    cursor: pointer;
    font-size: 14px;
    color: #5c4033;
}
.tipe-option:hover {
    border-color: #9c5638;
    background: #fdf6f0;
}
.tipe-option input { accent-color: #9c5638; }

@media (max-width: 560px) {
    .cart-item { flex-direction: column; align-items: flex-start; }
    .cart-item img { width: 100%; height: 180px; }
}
</style>

@auth
<script>
let cart = JSON.parse(localStorage.getItem('cart')) || [];
let appliedPromo = null;

function getSubtotal() {
    return cart.reduce((sum, item) => sum + item.price * item.qty, 0);
}

function updateTotals() {
    const subtotal = getSubtotal();
    const diskon = appliedPromo ? appliedPromo.diskon : 0;
    const total = Math.max(0, subtotal - diskon);

    const elTotal = document.getElementById('cart-total');
    if (elTotal) elTotal.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');

    const rowDiskon = document.getElementById('row-diskon');
    const cartDiskon = document.getElementById('cart-diskon');
    const cartGrand = document.getElementById('cart-grand');

    if (rowDiskon && cartDiskon) {
        if (diskon > 0) {
            rowDiskon.style.display = 'flex';
            cartDiskon.textContent = '- Rp ' + diskon.toLocaleString('id-ID');
        } else {
            rowDiskon.style.display = 'none';
        }
    }
    if (cartGrand) cartGrand.textContent = 'Rp ' + total.toLocaleString('id-ID');
}

async function terapkanPromo() {
    const kode = document.getElementById('kode_promo').value.trim();
    const msg = document.getElementById('promo-msg');

    if (!kode) {
        msg.style.color = '#c0392b';
        msg.textContent = 'Masukkan kode promo dulu.';
        return;
    }

    const subtotal = getSubtotal();
    if (subtotal === 0) {
        msg.style.color = '#c0392b';
        msg.textContent = 'Keranjang masih kosong.';
        return;
    }

    try {
        const res = await fetch('{{ route("promo.cek") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ kode: kode, subtotal: subtotal }),
        });
        const data = await res.json();

        if (!data.ok) {
            appliedPromo = null;
            msg.style.color = '#c0392b';
            msg.textContent = data.message;
            updateTotals();
            return;
        }

        appliedPromo = { kode: data.kode, diskon: data.diskon };
        msg.style.color = '#27ae60';
        msg.textContent = data.message + ' (− Rp ' + data.diskon.toLocaleString('id-ID') + ')';
        updateTotals();
    } catch (e) {
        msg.style.color = '#c0392b';
        msg.textContent = 'Gagal cek promo. Coba lagi.';
    }
}

function renderCart() {
    const container = document.getElementById('cart-items');
    const summary = document.getElementById('cart-summary');
    if (!container) return;

    container.innerHTML = '';
    let total = 0;

    if (cart.length === 0) {
        container.innerHTML = `
            <div class="cart-empty-box">
                <div style="font-size:40px; margin-bottom:12px;">🛒</div>
                <p style="margin-bottom:8px; font-weight:600; color:#3f2a20;">Keranjang masih kosong</p>
                <p style="margin-bottom:20px; color:#6b5244; font-size:14px;">Yuk pilih menu favoritmu dulu</p>
                <a href="/menu" class="btn btn-primary">Lihat Menu</a>
            </div>
        `;
        if (summary) summary.style.display = 'none';
        updateCartCount();
        return;
    }

    if (summary) summary.style.display = 'block';

    cart.forEach((item, index) => {
        total += item.price * item.qty;
        const div = document.createElement('div');
        div.className = 'cart-item';
        div.innerHTML = `
            <img src="${item.image}" alt="${item.name}" onerror="this.src='https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=200&q=80'">
            <div class="cart-item-info">
                <h3>${item.name}</h3>
                <div class="price">Rp ${item.price.toLocaleString('id-ID')}</div>
                <div class="qty-control">
                    <button onclick="changeQty(${index}, -1)" type="button">−</button>
                    <span style="font-weight:600; min-width:24px; text-align:center;">${item.qty}</span>
                    <button onclick="changeQty(${index}, 1)" type="button">+</button>
                    <button class="remove-btn" onclick="removeFromCart(${index})" type="button">Hapus</button>
                </div>
            </div>
        `;
        container.appendChild(div);
    });

    updateTotals();
    updateCartCount();
}

function updateCartCount() {
    const count = cart.reduce((sum, item) => sum + item.qty, 0);
    const badge = document.getElementById('cart-count');
    if (badge) badge.textContent = count;
}

function changeQty(index, change) {
    cart[index].qty += change;
    if (cart[index].qty < 1) cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    renderCart();
}

function removeFromCart(index) {
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    renderCart();
}

function toggleMeja() {
    const tipe = document.querySelector('input[name="tipe_pesanan"]:checked')?.value;
    const mejaBox = document.getElementById('meja-box');
    if (mejaBox) mejaBox.style.display = tipe === 'dine_in' ? 'block' : 'none';
}

function prosesCheckout() {
    if (cart.length === 0) {
        showToast('Keranjang masih kosong!', 'error');
        return;
    }

    const tipe = document.querySelector('input[name="tipe_pesanan"]:checked')?.value;
    const meja = document.getElementById('nomor_meja')?.value || '';
    const metode = document.querySelector('input[name="metode_pembayaran"]:checked')?.value;
    const catatan = document.getElementById('catatan')?.value || '';

    if (tipe === 'dine_in' && !meja) {
        showToast('Silakan pilih nomor meja untuk dine-in', 'error');
        return;
    }

    // Langsung checkout tanpa confirm browser
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("checkout") }}';

    const fields = {
        _token: '{{ csrf_token() }}',
        cart: JSON.stringify(cart),
        tipe_pesanan: tipe,
        nomor_meja: meja,
        metode_pembayaran: metode,
        catatan: catatan,
        kode_promo: appliedPromo ? appliedPromo.kode : '',
        diskon: appliedPromo ? appliedPromo.diskon : 0,
    };

    for (const [key, value] of Object.entries(fields)) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    }

    document.body.appendChild(form);
    localStorage.removeItem('cart');
    form.submit();
}

renderCart();
</script>
@endauth
@endsection