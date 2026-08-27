<div class="order-card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; flex-wrap:wrap; gap:12px;">
        <div>
            <strong style="font-size:1.1rem;">{{ $order->kode_order }}</strong>
            <div style="font-size:13px; color:#888; margin-top:4px;">
                {{ $order->created_at->format('d M Y, H:i') }}
            </div>
        </div>
        <div>
            @if($order->status == 'pending')
                <span style="background:#fff3cd; color:#856404; padding:5px 14px; border-radius:20px; font-size:13px; font-weight:600;">Pending</span>
            @elseif($order->status == 'process')
                <span style="background:#cce5ff; color:#004085; padding:5px 14px; border-radius:20px; font-size:13px; font-weight:600;">Diproses</span>
            @elseif($order->status == 'done')
                <span style="background:#d4edda; color:#155724; padding:5px 14px; border-radius:20px; font-size:13px; font-weight:600;">Selesai</span>
            @else
                <span style="background:#f8d7da; color:#721c24; padding:5px 14px; border-radius:20px; font-size:13px; font-weight:600;">Dibatalkan</span>
            @endif
        </div>
    </div>

    <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:16px;">
        <span style="background:#f8f1e9; color:#9c5638; font-size:12px; font-weight:600; padding:5px 12px; border-radius:20px;">
            @if(($order->tipe_pesanan ?? '') === 'dine_in')
                🍽️ Dine-in @if($order->nomor_meja) · {{ $order->nomor_meja }} @endif
            @else
                🥡 Takeaway
            @endif
        </span>
        <span style="background:#f0f7f0; color:#2d6a4f; font-size:12px; font-weight:600; padding:5px 12px; border-radius:20px;">
            @if(($order->metode_pembayaran ?? '') === 'transfer') 🏦 Transfer
            @elseif(($order->metode_pembayaran ?? '') === 'qris') 📱 QRIS
            @else 💵 Tunai
            @endif
        </span>
    </div>

    <div style="border-top:1px solid #f0e6d8; padding-top:14px;">
        @foreach($order->items as $item)
            <div style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:14.5px;">
                <span>{{ $item->nama_produk }} × {{ $item->qty }}</span>
                <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
        @endforeach
    </div>

    {{-- Diskon (jika ada) --}}
@if(!empty($order->diskon) && $order->diskon > 0)
    <div style="display:flex; justify-content:space-between; margin-top:10px; font-size:13.5px; color:#27ae60;">
        <span>
            Diskon
            @if($order->kode_promo)
                <span style="background:#eafaf1; color:#1e8449; font-size:11px; font-weight:600; padding:2px 8px; border-radius:20px; margin-left:4px;">
                    {{ $order->kode_promo }}
                </span>
            @endif
        </span>
        <span>− Rp {{ number_format($order->diskon, 0, ',', '.') }}</span>
    </div>
@endif

{{-- Total --}}
<div style="border-top:1px solid #f0e6d8; margin-top:12px; padding-top:12px; display:flex; justify-content:space-between; align-items:center;">
    <span style="font-weight:600;">Total</span>
    <strong style="font-size:1.15rem; color:#9c5638;">
        Rp {{ number_format($order->total, 0, ',', '.') }}
    </strong>
</div>

    @if($order->catatan)
        <div style="margin-top:10px; font-size:13px; color:#6b5244;">
            Catatan: {{ $order->catatan }}
        </div>
    @endif

    @if($order->status === 'cancelled')
        <div style="margin-top:14px; background:#fff5f5; border:1px solid #f5c6cb; border-radius:12px; padding:14px 16px;">
            <div style="font-size:13px; font-weight:600; color:#721c24; margin-bottom:4px;">🔔 Pesanan Dibatalkan</div>
            <p style="font-size:13.5px; color:#5c4033; margin:0; line-height:1.5;">
                @if($order->alasan_batal)
                    <strong>Alasan:</strong> {{ $order->alasan_batal }}
                @else
                    Pesanan dibatalkan oleh restoran.
                @endif
            </p>
        </div>
    @endif

    @if(in_array($order->metode_pembayaran ?? '', ['transfer', 'qris']) && $order->status === 'pending')
        <div style="margin-top:14px; background:#fff9f0; border:1px solid #f0e6d8; border-radius:12px; padding:14px 16px;">
            <div style="font-size:13px; font-weight:600; color:#9c5638; margin-bottom:6px;">Instruksi Pembayaran</div>
            <p style="font-size:13.5px; color:#5c4033; margin:0; line-height:1.6;">
                @if($order->metode_pembayaran === 'transfer')
                    Transfer ke rekening Warso, lalu konfirmasi WA
                    <a href="https://wa.me/6281367787355?text=Konfirmasi%20bayar%20{{ $order->kode_order }}" target="_blank" style="color:#9c5638; font-weight:600;">0813-6778-7355</a>
                @else
                    Bayar via QRIS di lokasi / kasir. Konfirmasi WA
                    <a href="https://wa.me/6281367787355?text=Konfirmasi%20QRIS%20{{ $order->kode_order }}" target="_blank" style="color:#9c5638; font-weight:600;">0813-6778-7355</a>
                @endif
            </p>
        </div>
    @endif

    {{-- Aksi User: Batalkan / Ajukan --}}
@if($order->status === 'pending')
    @if($order->cancel_request)
        <div style="margin-top:14px; background:#fff8e6; border:1px solid #f0e0b2; border-radius:12px; padding:14px 16px;">
            <div style="font-size:13px; font-weight:600; color:#856404; margin-bottom:4px;">
                ⏳ Menunggu konfirmasi pembatalan
            </div>
            <p style="font-size:13px; color:#5c4033; margin:0;">
                Alasan: {{ $order->alasan_batal_user }}
            </p>
        </div>
    @elseif(in_array($order->metode_pembayaran ?? '', ['transfer', 'qris']))
        <div style="margin-top:14px; background:#fff9f0; border:1px solid #f0e6d8; border-radius:12px; padding:14px 16px;">
            <div style="font-size:13px; font-weight:600; color:#9c5638; margin-bottom:6px;">
                Batalkan Pesanan
            </div>
            <p style="font-size:13px; color:#5c4033; margin:0 0 12px; line-height:1.5;">
                Karena pembayaran via Transfer/QRIS, pembatalan perlu dikonfirmasi restoran
                (termasuk pengembalian dana jika sudah transfer).
            </p>
            <button type="button"
                onclick="openUserCancelModal({{ $order->id }}, '{{ $order->kode_order }}', 'request')"
                style="padding:9px 16px; border-radius:10px; border:none; background:#e74c3c; color:white; font-size:13px; font-weight:600; cursor:pointer;">
                Ajukan Pembatalan
            </button>
            <a href="{{ route('kontak') }}" style="margin-left:10px; font-size:13px; color:#9c5638; font-weight:600;">
                Hubungi Kami
            </a>
        </div>
    @else
        <div style="margin-top:14px;">
            <button type="button"
                onclick="openUserCancelModal({{ $order->id }}, '{{ $order->kode_order }}', 'direct')"
                style="padding:9px 16px; border-radius:10px; border:1.5px solid #e74c3c; background:white; color:#e74c3c; font-size:13px; font-weight:600; cursor:pointer;">
                Batalkan Pesanan
            </button>
        </div>
    @endif
@endif
</div>