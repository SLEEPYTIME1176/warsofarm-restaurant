@extends('layouts.app')

@section('content')
<div class="container" style="padding: 60px 24px 80px;">
    <div class="section-header">
        <h2>Keranjang Belanja</h2>
        <p>Periksa pesanan Anda sebelum checkout</p>
    </div>

    @guest
        <div style="text-align:center; padding:40px; background:white; border-radius:20px; max-width:500px; margin:0 auto;">
            <p style="margin-bottom:20px; color:#6b5244;">Silakan login terlebih dahulu untuk checkout</p>
            <a href="{{ route('login') }}" class="btn btn-primary">Login Sekarang</a>
        </div>
    @else
        <div id="cart-items" class="cart-list"></div>

        <div class="cart-summary">
            <div class="cart-total">
                <span>Total</span>
                <strong id="cart-total">Rp 0</strong>
            </div>

            <div style="margin-top:20px;">
                <label style="font-weight:600; margin-bottom:8px; display:block;">Catatan (opsional)</label>
                <textarea id="catatan" rows="2" placeholder="Contoh: Extra pedas, tanpa bawang..." 
                    style="width:100%; padding:12px; border:1px solid #e8ddd0; border-radius:12px; font-size:14px;"></textarea>
            </div>

            <button onclick="prosesCheckout()" class="btn btn-primary" style="width:100%; margin-top:20px; padding:16px;">
                Checkout Sekarang
            </button>
        </div>
    @endguest
</div>

<script>
let cart = JSON.parse(localStorage.getItem('cart')) || [];

function renderCart() {
    const container = document.getElementById('cart-items');
    if (!container) return;

    container.innerHTML = '';
    let total = 0;

    if (cart.length === 0) {
        container.innerHTML = '<p style="text-align:center; padding:60px 0; color:#6b5244;">Keranjang masih kosong</p>';
        document.getElementById('cart-total').textContent = 'Rp 0';
        return;
    }

    cart.forEach((item, index) => {
        total += item.price * item.qty;
        const div = document.createElement('div');
        div.className = 'cart-item';
        div.innerHTML = `
            <img src="${item.image}" alt="${item.name}">
            <div class="cart-item-info">
                <h3>${item.name}</h3>
                <p>Rp ${item.price.toLocaleString('id-ID')}</p>
                <div class="qty-control">
                    <button onclick="changeQty(${index}, -1)">−</button>
                    <span>${item.qty}</span>
                    <button onclick="changeQty(${index}, 1)">+</button>
                    <button class="remove-btn" onclick="removeFromCart(${index})">Hapus</button>
                </div>
            </div>
        `;
        container.appendChild(div);
    });

    document.getElementById('cart-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
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

function prosesCheckout() {
    if (cart.length === 0) {
        alert('Keranjang masih kosong!');
        return;
    }

    if (!confirm('Yakin ingin checkout sekarang?')) return;

    // Buat form tersembunyi untuk kirim data
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("checkout") }}';

    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';
    form.appendChild(csrf);

    const cartInput = document.createElement('input');
    cartInput.type = 'hidden';
    cartInput.name = 'cart';
    cartInput.value = JSON.stringify(cart);
    form.appendChild(cartInput);

    const catatan = document.createElement('input');
    catatan.type = 'hidden';
    catatan.name = 'catatan';
    catatan.value = document.getElementById('catatan')?.value || '';
    form.appendChild(catatan);

    document.body.appendChild(form);
    form.submit();

    // Kosongkan keranjang setelah submit
    localStorage.removeItem('cart');
}

@auth
renderCart();
@endauth
</script>
@endsection