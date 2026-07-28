@extends('layouts.app')

@section('content')
<div class="container" style="padding: 60px 24px 80px;">
    <div class="section-header">
        <h2>Riwayat Pesanan</h2>
        <p>Daftar pesanan yang pernah Anda buat</p>
    </div>

    @if(session('success'))
        <div style="max-width:700px; margin:0 auto 30px; background:#d4edda; color:#155724; padding:16px 20px; border-radius:14px; text-align:center;">
            {{ session('success') }}
        </div>
    @endif

    @forelse($orders as $order)
        <div style="background:white; border-radius:20px; padding:28px; margin-bottom:24px; box-shadow:0 10px 28px rgba(90,55,30,0.07); max-width:800px; margin-left:auto; margin-right:auto;">
            
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; flex-wrap:wrap; gap:12px;">
                <div>
                    <strong style="font-size:1.1rem;">{{ $order->kode_order }}</strong>
                    <div style="font-size:13px; color:#888; margin-top:4px;">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </div>
                </div>
                <div>
                    @if($order->status == 'pending')
                        <span style="background:#fff3cd; color:#856404; padding:5px 14px; border-radius:20px; font-size:13px;">Pending</span>
                    @elseif($order->status == 'process')
                        <span style="background:#cce5ff; color:#004085; padding:5px 14px; border-radius:20px; font-size:13px;">Diproses</span>
                    @elseif($order->status == 'done')
                        <span style="background:#d4edda; color:#155724; padding:5px 14px; border-radius:20px; font-size:13px;">Selesai</span>
                    @else
                        <span style="background:#f8d7da; color:#721c24; padding:5px 14px; border-radius:20px; font-size:13px;">Dibatalkan</span>
                    @endif
                </div>
            </div>

            <div style="border-top:1px solid #f0e6d8; padding-top:16px;">
                @foreach($order->items as $item)
                    <div style="display:flex; justify-content:space-between; margin-bottom:10px; font-size:14.5px;">
                        <span>{{ $item->nama_produk }} × {{ $item->qty }}</span>
                        <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>

            <div style="border-top:1px solid #f0e6d8; margin-top:14px; padding-top:14px; display:flex; justify-content:space-between; align-items:center;">
                <span style="font-weight:600;">Total</span>
                <strong style="font-size:1.2rem; color:var(--primary);">
                    Rp {{ number_format($order->total, 0, ',', '.') }}
                </strong>
            </div>

            @if($order->catatan)
                <div style="margin-top:12px; font-size:13px; color:#6b5244;">
                    Catatan: {{ $order->catatan }}
                </div>
            @endif
        </div>
    @empty
        <div style="text-align:center; padding:60px 20px; background:white; border-radius:20px; max-width:500px; margin:0 auto;">
            <p style="color:#6b5244; margin-bottom:20px;">Belum ada riwayat pesanan</p>
            <a href="{{ route('menu') }}" class="btn btn-primary">Lihat Menu</a>
        </div>
    @endforelse
</div>
@endsection