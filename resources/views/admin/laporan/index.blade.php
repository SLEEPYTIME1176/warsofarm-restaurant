@extends('admin.layouts.app')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:28px;">
    <h1 class="page-title" style="margin:0;">Laporan</h1>
</div>

{{-- STAT CARDS --}}
<div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:18px; margin-bottom:28px;">
    <div style="background:white; border-radius:16px; padding:22px 20px; box-shadow:0 4px 18px rgba(0,0,0,0.05);">
        <div style="font-size:13px; color:#888; margin-bottom:6px;">Total Reservasi</div>
        <div style="font-size:28px; font-weight:700; color:#3f2a20;">{{ $totalReservasi ?? 0 }}</div>
    </div>
    <div style="background:white; border-radius:16px; padding:22px 20px; box-shadow:0 4px 18px rgba(0,0,0,0.05);">
        <div style="font-size:13px; color:#888; margin-bottom:6px;">Pending</div>
        <div style="font-size:28px; font-weight:700; color:#d4a017;">{{ $pending ?? 0 }}</div>
    </div>
    <div style="background:white; border-radius:16px; padding:22px 20px; box-shadow:0 4px 18px rgba(0,0,0,0.05);">
        <div style="font-size:13px; color:#888; margin-bottom:6px;">Confirmed</div>
        <div style="font-size:28px; font-weight:700; color:#27ae60;">{{ $confirmed ?? 0 }}</div>
    </div>
    <div style="background:white; border-radius:16px; padding:22px 20px; box-shadow:0 4px 18px rgba(0,0,0,0.05);">
        <div style="font-size:13px; color:#888; margin-bottom:6px;">Cancelled</div>
        <div style="font-size:28px; font-weight:700; color:#e74c3c;">{{ $cancelled ?? 0 }}</div>
    </div>
</div>

{{-- 2 KOLOM --}}
<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:28px;">
    {{-- Ringkasan Lainnya --}}
    <div class="card" style="padding:22px 24px;">
        <h3 style="margin:0 0 16px; font-size:16px; color:#3f2a20;">Ringkasan Lainnya</h3>
        <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid #f0e6d8; font-size:14px;">
            <span style="color:#666;">Reservasi Bulan Ini</span>
            <strong>{{ $reservasiBulanIni ?? 0 }}</strong>
        </div>
        <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid #f0e6d8; font-size:14px;">
            <span style="color:#666;">Total Menu</span>
            <strong>{{ $totalMenu ?? 0 }}</strong>
        </div>
        <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid #f0e6d8; font-size:14px;">
            <span style="color:#666;">Menu Populer</span>
            <strong>{{ $menuPopuler ?? 0 }}</strong>
        </div>
        <div style="display:flex; justify-content:space-between; padding:12px 0; font-size:14px;">
            <span style="color:#666;">Total Kategori</span>
            <strong>{{ $totalKategori ?? 0 }}</strong>
        </div>
    </div>

    {{-- Status Reservasi --}}
    <div class="card" style="padding:22px 24px;">
        <h3 style="margin:0 0 16px; font-size:16px; color:#3f2a20;">Status Reservasi</h3>
        @php
            $total = max(1, ($pending ?? 0) + ($confirmed ?? 0) + ($cancelled ?? 0));
        @endphp
        <div style="margin-bottom:14px;">
            <div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:6px;">
                <span>Pending</span><strong>{{ $pending ?? 0 }}</strong>
            </div>
            <div style="height:8px; background:#eee; border-radius:10px; overflow:hidden;">
                <div style="height:100%; width:{{ round(($pending ?? 0) / $total * 100) }}%; background:#d4a017;"></div>
            </div>
        </div>
        <div style="margin-bottom:14px;">
            <div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:6px;">
                <span>Confirmed</span><strong>{{ $confirmed ?? 0 }}</strong>
            </div>
            <div style="height:8px; background:#eee; border-radius:10px; overflow:hidden;">
                <div style="height:100%; width:{{ round(($confirmed ?? 0) / $total * 100) }}%; background:#27ae60;"></div>
            </div>
        </div>
        <div>
            <div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:6px;">
                <span>Cancelled</span><strong>{{ $cancelled ?? 0 }}</strong>
            </div>
            <div style="height:8px; background:#eee; border-radius:10px; overflow:hidden;">
                <div style="height:100%; width:{{ round(($cancelled ?? 0) / $total * 100) }}%; background:#e74c3c;"></div>
            </div>
        </div>
    </div>
</div>

{{-- Reservasi Terbaru — biarkan tabel yang sudah ada --}}
<div class="card" style="padding:22px 24px;">
    <h3 style="margin:0 0 16px; font-size:16px; color:#3f2a20;">Reservasi Terbaru</h3>
    {{-- tempel tabel yang sudah kamu punya di sini --}}
</div>

<style>
@media (max-width: 900px) {
    div[style*="grid-template-columns:repeat(4"] {
        grid-template-columns: repeat(2, 1fr) !important;
    }
    div[style*="grid-template-columns:1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection