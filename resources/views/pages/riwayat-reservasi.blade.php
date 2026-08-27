@extends('layouts.app')

@section('content')
<div class="container" style="padding: 60px 24px 80px;">
    <div class="section-header">
        <h2>Riwayat Reservasi</h2>
        <p>Daftar reservasi meja Anda</p>
    </div>

    <div style="max-width:700px; margin:0 auto;">
        @forelse($reservasis as $item)
            <div class="riwayat-card {{ in_array($item->status, ['done','cancelled']) ? 'is-finished' : '' }}">
                <div class="riwayat-top">
                    <div>
                        <strong style="font-size:16px; color:#3f2a20;">{{ $item->nama }}</strong>
                        <div style="font-size:13px; color:#8b7355; margin-top:4px;">
                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                            · {{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }} WIB
                        </div>
                    </div>
                    <span class="status-badge status-{{ $item->status ?? 'pending' }}">
                        @if(($item->status ?? 'pending') === 'confirmed')
                            ✅ Dikonfirmasi
                        @elseif(($item->status ?? '') === 'cancelled')
                            ❌ Dibatalkan
                        @elseif(($item->status ?? '') === 'done')
                            ✔️ Selesai
                        @else
                            ⏳ Menunggu
                        @endif
                    </span>
                </div>

                <div class="riwayat-body">
                    <div><span>Jumlah</span> {{ $item->jumlah_orang }} orang</div>
                    @if($item->telepon)
                        <div><span>Telepon</span> {{ $item->telepon }}</div>
                    @endif
                    @if($item->email)
                        <div><span>Email</span> {{ $item->email }}</div>
                    @endif
                    @if($item->catatan)
                        <div style="grid-column:1/-1;"><span>Catatan</span> {{ $item->catatan }}</div>
                    @endif
                </div>

                {{-- Alasan dibatalkan --}}
                @if($item->status === 'cancelled' && $item->alasan_batal)
                    <div class="alasan-box">
                        <strong>Alasan dibatalkan:</strong> {{ $item->alasan_batal }}
                    </div>
                @endif

                {{-- Tombol batal (hanya pending) --}}
                @if($item->status === 'pending')
                    <form action="{{ route('reservasi.batal', $item->id) }}" method="POST"
                          style="margin-top:14px;"
                          onsubmit="return confirmBatalCozy(event, this)">
                        @csrf
                        <input type="text" name="alasan_batal"
                               placeholder="Contoh: Saya memiliki jadwal baru"
                               required
                               style="width:100%; padding:8px 10px; border-radius:8px; border:1px solid #e8ddd0; margin-bottom:8px; font-size:13px; box-sizing:border-box; font-family:inherit;">
                        <button type="submit" class="btn-batal">
                            Batalkan Reservasi
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <div style="text-align:center; padding:60px 20px; color:#8b7355;">
                <p style="font-size:15px; margin-bottom:16px;">Belum ada reservasi.</p>
                <a href="{{ route('reservasi') }}" class="btn btn-primary">Buat Reservasi</a>
            </div>
        @endforelse
    </div>
</div>

{{-- Toast dari session --}}
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof showToast === 'function') {
        showToast(@json(session('success')), 'success');
    }
});
</script>
@endif

@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof showToast === 'function') {
        showToast(@json(session('error')), 'error');
    }
});
</script>
@endif

<style>
.riwayat-card {
    background: white;
    border: 1px solid #f0e6d8;
    border-radius: 16px;
    padding: 18px 20px;
    margin-bottom: 14px;
    box-shadow: 0 4px 16px rgba(63,42,32,0.04);
    transition: opacity 0.2s;
}
.riwayat-card.is-finished {
    opacity: 0.7;
}
.riwayat-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 14px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f5efe8;
}
.status-badge {
    font-size: 12px;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 20px;
    white-space: nowrap;
}
.status-pending { background: #fff3cd; color: #856404; }
.status-confirmed { background: #d4edda; color: #155724; }
.status-cancelled { background: #f8d7da; color: #721c24; }
.status-done { background: #e8e8e8; color: #555; }

.riwayat-body {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px 16px;
    font-size: 13.5px;
    color: #3f2a20;
}
.riwayat-body span {
    display: block;
    font-size: 11.5px;
    color: #8b7355;
    margin-bottom: 2px;
}
.alasan-box {
    margin-top: 12px;
    padding: 10px 12px;
    background: #fdf0f0;
    border-radius: 10px;
    font-size: 13px;
    color: #721c24;
    line-height: 1.45;
}
.btn-batal {
    background: #c0392b;
    color: white;
    border: none;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    cursor: pointer;
    font-family: inherit;
}
.btn-batal:hover {
    background: #a93226;
}
@media (max-width: 520px) {
    .riwayat-body { grid-template-columns: 1fr; }
}
</style>

{{-- Modal konfirmasi cozy --}}
<div id="batal-modal" style="display:none; position:fixed; inset:0; background:rgba(63,42,32,0.35); z-index:9998; align-items:center; justify-content:center;">
    <div style="background:#fffaf0; border-radius:16px; padding:28px 24px; max-width:340px; width:90%; box-shadow:0 16px 48px rgba(0,0,0,0.15); text-align:center;">
        <div style="font-size:28px; margin-bottom:12px;">🌿</div>
        <p style="font-size:15px; color:#3f2a20; margin:0 0 8px; font-weight:600;">Batalkan reservasi?</p>
        <p style="font-size:13px; color:#8b7355; margin:0 0 22px; line-height:1.5;">Reservasi yang dibatalkan tidak bisa dikembalikan.</p>
        <div style="display:flex; gap:10px; justify-content:center;">
            <button type="button" id="batal-modal-no"
                style="flex:1; padding:10px; border-radius:10px; border:1px solid #e8ddd0; background:white; color:#3f2a20; font-size:13px; cursor:pointer; font-family:inherit;">
                Kembali
            </button>
            <button type="button" id="batal-modal-yes"
                style="flex:1; padding:10px; border-radius:10px; border:none; background:#c0392b; color:white; font-size:13px; cursor:pointer; font-family:inherit;">
                Ya, batalkan
            </button>
        </div>
    </div>
</div>

<script>
var __batalForm = null;

function confirmBatalCozy(e, form) {
    e.preventDefault();
    __batalForm = form;
    document.getElementById('batal-modal').style.display = 'flex';
    return false;
}

document.getElementById('batal-modal-no')?.addEventListener('click', function () {
    document.getElementById('batal-modal').style.display = 'none';
    __batalForm = null;
});

document.getElementById('batal-modal-yes')?.addEventListener('click', function () {
    document.getElementById('batal-modal').style.display = 'none';
    if (__batalForm) __batalForm.submit();
});
</script>

@endsection