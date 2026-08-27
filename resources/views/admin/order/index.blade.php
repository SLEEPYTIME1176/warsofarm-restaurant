@extends('admin.layouts.app')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
    <h1 class="page-title" style="margin:0;">Data Pesanan</h1>
</div>

@if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:14px 20px; border-radius:10px; margin-bottom:24px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background:#f8d7da; color:#721c24; padding:14px 20px; border-radius:10px; margin-bottom:24px;">
        {{ session('error') }}
    </div>
@endif

<div class="card" style="overflow-x:auto;">
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Customer</th>
                <th>Item</th>
                <th>Total</th>
                <th>Tipe</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr style="{{ $order->cancel_request && $order->status === 'pending' ? 'background:#fff8f0;' : '' }}">
                    <td>
                        <strong>{{ $order->kode_order }}</strong>
                        @if($order->status === 'cancelled' && $order->alasan_batal)
                            <div style="font-size:11px; color:#c0392b; margin-top:4px;">
                                {{ $order->alasan_batal }}
                            </div>
                        @endif
                        @if($order->cancel_request && $order->status === 'pending')
                            <div style="margin-top:6px; background:#fff3cd; color:#856404; font-size:11px; font-weight:600; padding:4px 8px; border-radius:6px; display:inline-block;">
                                ⚠ User ajukan batal
                            </div>
                            @if($order->alasan_batal_user)
                                <div style="font-size:11px; color:#856404; margin-top:3px;">
                                    "{{ $order->alasan_batal_user }}"
                                </div>
                            @endif
                        @endif
                    </td>
                    <td>
                        {{ $order->user->name ?? '-' }}<br>
                        <small style="color:#888;">{{ $order->user->email ?? '' }}</small>
                    </td>
                    <td>
                        @foreach($order->items as $item)
                            <div style="font-size:13px; margin-bottom:2px;">
                                {{ $item->nama_produk }} × {{ $item->qty }}
                            </div>
                        @endforeach
                    </td>
                    <td>
                        <div>
    <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
    @if(!empty($order->diskon) && $order->diskon > 0)
        <div style="font-size:11px; color:#27ae60; margin-top:2px;">
            − Rp {{ number_format($order->diskon, 0, ',', '.') }}
            @if($order->kode_promo)
                ({{ $order->kode_promo }})
            @endif
        </div>
    @endif
</div>
                    </td>
                    <td style="font-size:12px;">
                        @if(($order->tipe_pesanan ?? '') === 'dine_in')
                            🍽️ Dine-in
                            @if($order->nomor_meja)
                                <br><small>{{ $order->nomor_meja }}</small>
                            @endif
                        @else
                            🥡 Takeaway
                        @endif
                        <br>
                        <small style="color:#888;">
                            @if(($order->metode_pembayaran ?? '') === 'transfer') Transfer
                            @elseif(($order->metode_pembayaran ?? '') === 'qris') QRIS
                            @else Tunai
                            @endif
                        </small>
                    </td>
                    <td>
                        @if($order->status == 'pending')
                            <span style="background:#fff3cd; color:#856404; padding:4px 10px; border-radius:20px; font-size:12px;">Pending</span>
                        @elseif($order->status == 'process')
                            <span style="background:#cce5ff; color:#004085; padding:4px 10px; border-radius:20px; font-size:12px;">Diproses</span>
                        @elseif($order->status == 'done')
                            <span style="background:#d4edda; color:#155724; padding:4px 10px; border-radius:20px; font-size:12px;">Selesai</span>
                        @else
                            <span style="background:#f8d7da; color:#721c24; padding:4px 10px; border-radius:20px; font-size:12px;">Dibatalkan</span>
                        @endif
                    </td>
                    <td style="font-size:13px;">
                        {{ $order->created_at->format('d M Y H:i') }}
                    </td>
                    <td style="min-width:140px;">
                        @if($order->status !== 'cancelled' && $order->status !== 'done')
                            {{-- Ubah status --}}
                            <form action="{{ route('admin.order.status', $order->id) }}" method="POST" style="margin-bottom:8px;">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()"
                                    style="width:100%; padding:6px 8px; border-radius:8px; border:1px solid #ddd; font-size:12px;">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="process" {{ $order->status == 'process' ? 'selected' : '' }}>Diproses</option>
                                    <option value="done" {{ $order->status == 'done' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </form>

                            {{-- Setujui pengajuan user --}}
                            @if($order->cancel_request)
                                <form action="{{ url('/admin/order/'.$order->id.'/cancel') }}" method="POST" style="margin-bottom:6px;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="alasan_batal" value="{{ $order->alasan_batal_user ?? 'Disetujui admin (pengajuan user)' }}">
                                    <button type="submit"
                                        style="width:100%; padding:6px 10px; border:none; border-radius:8px; background:#e67e22; color:white; font-size:12px; font-weight:600; cursor:pointer;">
                                        Setujui Batal User
                                    </button>
                                </form>
                            @endif

                            {{-- Batalkan manual admin --}}
                            <button type="button"
                                onclick="openCancelModal({{ $order->id }}, '{{ $order->kode_order }}')"
                                style="width:100%; padding:6px 10px; border:none; border-radius:8px; background:#e74c3c; color:white; font-size:12px; cursor:pointer;">
                                Batalkan
                            </button>
                        @else
                            <span style="font-size:12px; color:#999;">—</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:40px; color:#999;">
                        Belum ada pesanan
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal Batalkan (Admin) --}}
<div id="cancelModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:999; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:16px; padding:28px; max-width:440px; width:90%; box-shadow:0 20px 50px rgba(0,0,0,0.2);">
        <h3 style="margin:0 0 6px; font-size:1.15rem; color:#3f2a20;">Batalkan Pesanan</h3>
        <p style="font-size:13px; color:#666; margin:0 0 18px;" id="cancelKode"></p>

        <form id="cancelForm" method="POST">
            @csrf

            <label style="font-size:13px; font-weight:600; display:block; margin-bottom:12px; color:#3f2a20;">
                Pilih alasan pembatalan:
            </label>

            <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:22px;">
                <label style="display:flex; gap:10px; align-items:center; font-size:14px; cursor:pointer;">
                    <input type="radio" name="alasan_batal" value="Menu habis" required style="accent-color:#9c5638;"> Menu habis
                </label>
                <label style="display:flex; gap:10px; align-items:center; font-size:14px; cursor:pointer;">
                    <input type="radio" name="alasan_batal" value="Restoran sedang tutup" style="accent-color:#9c5638;"> Restoran sedang tutup
                </label>
                <label style="display:flex; gap:10px; align-items:center; font-size:14px; cursor:pointer;">
                    <input type="radio" name="alasan_batal" value="Gangguan teknis" style="accent-color:#9c5638;"> Gangguan teknis
                </label>
                <label style="display:flex; gap:10px; align-items:center; font-size:14px; cursor:pointer;">
                    <input type="radio" name="alasan_batal" value="Bahan baku tidak tersedia" style="accent-color:#9c5638;"> Bahan baku tidak tersedia
                </label>
                <label style="display:flex; gap:10px; align-items:center; font-size:14px; cursor:pointer;">
                    <input type="radio" name="alasan_batal" value="Pesanan tidak dapat diproses" style="accent-color:#9c5638;"> Pesanan tidak dapat diproses
                </label>
                <label style="display:flex; gap:10px; align-items:center; font-size:14px; cursor:pointer;">
                    <input type="radio" name="alasan_batal" value="Pengajuan user disetujui" style="accent-color:#9c5638;"> Pengajuan user disetujui
                </label>
                <label style="display:flex; gap:10px; align-items:center; font-size:14px; cursor:pointer;">
                    <input type="radio" name="alasan_batal" value="Lainnya" style="accent-color:#9c5638;"> Lainnya
                </label>
            </div>

            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" onclick="closeCancelModal()"
                    style="padding:10px 18px; border-radius:10px; border:1px solid #ddd; background:#f5f5f5; cursor:pointer; font-size:14px;">
                    Tutup
                </button>
                <button type="submit"
                    style="padding:10px 18px; border-radius:10px; border:none; background:#e74c3c; color:white; cursor:pointer; font-size:14px; font-weight:600;">
                    Konfirmasi Batalkan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openCancelModal(id, kode) {
    document.getElementById('cancelKode').textContent = 'Kode pesanan: ' + kode;
    document.getElementById('cancelForm').action = "{{ url('/admin/order') }}/" + id + "/cancel";
    document.getElementById('cancelModal').style.display = 'flex';
}
function closeCancelModal() {
    document.getElementById('cancelModal').style.display = 'none';
}
document.getElementById('cancelModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeCancelModal();
});
</script>
@endsection