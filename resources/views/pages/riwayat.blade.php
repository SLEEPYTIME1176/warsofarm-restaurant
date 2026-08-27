@extends('layouts.app')

@section('content')
<div class="container" style="padding: 60px 24px 80px;">
    <div class="section-header">
        <h2>Pesanan Saya</h2>
        <p>Pantau pesanan aktif dan lihat riwayatmu</p>
    </div>

    @if(session('success'))
    <div style="max-width:720px; margin:0 auto 20px; background:#d4edda; color:#155724; padding:14px 18px; border-radius:12px; text-align:center; font-size:14px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="max-width:720px; margin:0 auto 20px; background:#f8d7da; color:#721c24; padding:14px 18px; border-radius:12px; text-align:center; font-size:14px;">
        {{ session('error') }}
    </div>
@endif

    {{-- Tabs --}}
    <div class="order-tabs">
        <button type="button" class="order-tab active" data-tab="aktif" onclick="switchTab('aktif')">
            Pesanan Aktif
            @php $aktifCount = $orders->whereIn('status', ['pending', 'process'])->count(); @endphp
            @if($aktifCount > 0)
                <span class="tab-badge">{{ $aktifCount }}</span>
            @endif
        </button>
        <button type="button" class="order-tab" data-tab="riwayat" onclick="switchTab('riwayat')">
            Riwayat
        </button>
    </div>

    {{-- Tab: Pesanan Aktif --}}
    <div id="tab-aktif" class="tab-panel">
        @php $aktif = $orders->whereIn('status', ['pending', 'process']); @endphp

        @forelse($aktif as $order)
            @include('pages.partials.order-card', ['order' => $order])
        @empty
            <div class="order-empty">
                <div style="font-size:36px; margin-bottom:10px;">📦</div>
                <p style="font-weight:600; color:#3f2a20; margin-bottom:6px;">Belum ada pesanan aktif</p>
                <p style="color:#6b5244; font-size:14px; margin-bottom:18px;">Yuk pesan menu favoritmu</p>
                <a href="{{ route('menu') }}" class="btn btn-primary">Lihat Menu</a>
            </div>
        @endforelse
    </div>

    {{-- Tab: Riwayat --}}
    <div id="tab-riwayat" class="tab-panel" style="display:none;">
        @php $riwayat = $orders->whereIn('status', ['done', 'cancelled']); @endphp

        @forelse($riwayat as $order)
            @include('pages.partials.order-card', ['order' => $order])
        @empty
            <div class="order-empty">
                <div style="font-size:36px; margin-bottom:10px;">📋</div>
                <p style="font-weight:600; color:#3f2a20; margin-bottom:6px;">Belum ada riwayat</p>
                <p style="color:#6b5244; font-size:14px;">Pesanan selesai atau dibatalkan akan muncul di sini</p>
            </div>
        @endforelse
    </div>
</div>

<style>
.order-tabs {
    display: flex;
    gap: 8px;
    max-width: 720px;
    margin: 0 auto 28px;
    background: #f8f1e9;
    padding: 6px;
    border-radius: 14px;
}
.order-tab {
    flex: 1;
    padding: 12px 16px;
    border: none;
    background: transparent;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    color: #6b5244;
    cursor: pointer;
    transition: all 0.25s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.order-tab.active {
    background: white;
    color: #9c5638;
    box-shadow: 0 2px 10px rgba(90, 55, 30, 0.08);
}
.tab-badge {
    background: #9c5638;
    color: white;
    font-size: 11px;
    padding: 2px 7px;
    border-radius: 20px;
    min-width: 20px;
    text-align: center;
}
.order-empty {
    text-align: center;
    padding: 50px 24px;
    background: white;
    border-radius: 20px;
    max-width: 480px;
    margin: 0 auto;
    box-shadow: 0 8px 24px rgba(90, 55, 30, 0.06);
}
.order-card {
    background: white;
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 18px;
    box-shadow: 0 10px 28px rgba(90, 55, 30, 0.07);
    max-width: 720px;
    margin-left: auto;
    margin-right: auto;
}
</style>

<script>
function switchTab(tab) {
    document.querySelectorAll('.order-tab').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.tab === tab);
    });
    document.getElementById('tab-aktif').style.display = tab === 'aktif' ? 'block' : 'none';
    document.getElementById('tab-riwayat').style.display = tab === 'riwayat' ? 'block' : 'none';
}
</script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof showToast === 'function') {
            showToast(@json(session('success')), 'success');
        }
    });
</script>
@endif

{{-- Modal Batalkan / Ajukan (User) --}}
<div id="userCancelModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:999; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:16px; padding:28px; max-width:420px; width:90%; box-shadow:0 20px 50px rgba(0,0,0,0.2);">
        <h3 style="margin:0 0 6px; font-size:1.1rem; color:#3f2a20;" id="userCancelTitle">Batalkan Pesanan</h3>
        <p style="font-size:13px; color:#666; margin:0 0 16px;" id="userCancelKode"></p>

        <form id="userCancelForm" method="POST">
            @csrf

            <label style="font-size:13px; font-weight:600; display:block; margin-bottom:10px;">Alasan pembatalan:</label>
            <div style="display:flex; flex-direction:column; gap:8px; margin-bottom:20px;">
                <label style="display:flex; gap:8px; font-size:14px; cursor:pointer;"><input type="radio" name="alasan_batal" value="Salah pesan menu" required> Salah pesan menu</label>
                <label style="display:flex; gap:8px; font-size:14px; cursor:pointer;"><input type="radio" name="alasan_batal" value="Berubah pikiran"> Berubah pikiran</label>
                <label style="display:flex; gap:8px; font-size:14px; cursor:pointer;"><input type="radio" name="alasan_batal" value="Terlalu lama menunggu"> Terlalu lama menunggu</label>
                <label style="display:flex; gap:8px; font-size:14px; cursor:pointer;"><input type="radio" name="alasan_batal" value="Ingin ganti menu"> Ingin ganti menu</label>
                <label style="display:flex; gap:8px; font-size:14px; cursor:pointer;"><input type="radio" name="alasan_batal" value="Lainnya"> Lainnya</label>
            </div>

            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" onclick="closeUserCancelModal()"
                    style="padding:10px 16px; border-radius:10px; border:1px solid #ddd; background:#f5f5f5; cursor:pointer;">Batal</button>
                <button type="submit"
                    style="padding:10px 16px; border-radius:10px; border:none; background:#e74c3c; color:white; font-weight:600; cursor:pointer;">Konfirmasi</button>
            </div>
        </form>
    </div>
</div>

<script>
function openUserCancelModal(id, kode, type) {
    document.getElementById('userCancelKode').textContent = 'Kode: ' + kode;
    document.getElementById('userCancelTitle').textContent =
        type === 'request' ? 'Ajukan Pembatalan' : 'Batalkan Pesanan';

    const form = document.getElementById('userCancelForm');
    if (type === 'request') {
        form.action = '/pesanan/' + id + '/ajukan-batal';
    } else {
        form.action = '/pesanan/' + id + '/batal';
    }

    document.getElementById('userCancelModal').style.display = 'flex';
}
function closeUserCancelModal() {
    document.getElementById('userCancelModal').style.display = 'none';
}
document.getElementById('userCancelModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeUserCancelModal();
});
</script>

@endsection