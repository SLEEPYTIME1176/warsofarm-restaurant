@extends('layouts.app')

@section('content')
@php
    $kuotaHabis = $promo->kuota !== null && ($promo->terpakai ?? 0) >= $promo->kuota;
    $sisa = $promo->kuota !== null
        ? max(0, $promo->kuota - ($promo->terpakai ?? 0))
        : null;
@endphp

<div class="container" style="padding: 60px 24px 80px; max-width: 720px;">

    {{-- Tombol kembali --}}
    <div style="margin-bottom: 24px;">
        <a href="{{ url('/') }}"
           style="display: inline-flex; align-items: center; gap: 8px;
                  background: #f5ebe0; color: #9c5638; text-decoration: none;
                  padding: 10px 18px; border-radius: 12px; font-size: 14px; font-weight: 600;">
            ← Kembali ke Beranda
        </a>
    </div>

    <div style="background: white; border: 1px solid #f0e6d8; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 32px rgba(63,42,32,0.06); {{ $kuotaHabis ? 'opacity: 0.88;' : '' }}">

        {{-- Gambar --}}
        @if($promo->gambar)
            <div style="position: relative;">
                <img src="{{ asset('storage/'.$promo->gambar) }}"
                     alt="{{ $promo->judul }}"
                     style="width: 100%; height: 240px; object-fit: cover; display: block;
                            {{ $kuotaHabis ? 'filter: grayscale(0.45);' : '' }}">

                @if($kuotaHabis)
                    <span style="position: absolute; top: 16px; left: 16px;
                                 background: rgba(192, 57, 43, 0.95); color: white;
                                 font-size: 13px; font-weight: 700; padding: 7px 14px; border-radius: 20px;">
                        Kuota Habis
                    </span>
                @endif
            </div>
        @endif

        <div style="padding: 28px 24px;">
            <h1 style="margin: 0 0 8px; font-size: 26px; color: #3f2a20;">{{ $promo->judul }}</h1>

            @if($promo->deskripsi)
                <p style="color: #8b7355; line-height: 1.6; margin: 0 0 20px;">{{ $promo->deskripsi }}</p>
            @endif

            {{-- Kode & Diskon --}}
            <div style="display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
                <div style="background: #f5ebe0; padding: 12px 16px; border-radius: 12px;">
                    <div style="font-size: 11px; color: #8b7355;">Kode Promo</div>
                    <div style="font-size: 18px; font-weight: 700; color: #9c5638;" id="kode-promo">
                        {{ $promo->kode_promo }}
                    </div>
                </div>
                <div style="background: #faf6f1; padding: 12px 16px; border-radius: 12px;">
                    <div style="font-size: 11px; color: #8b7355;">Diskon</div>
                    <div style="font-size: 18px; font-weight: 700; color: #3f2a20;">
                        @if($promo->tipe === 'persen')
                            {{ $promo->nilai }}%
                        @else
                            Rp {{ number_format($promo->nilai, 0, ',', '.') }}
                        @endif
                    </div>
                </div>
            </div>

            {{-- Info --}}
            <ul style="list-style: none; padding: 0; margin: 0 0 24px; font-size: 14px; color: #3f2a20; line-height: 1.9;">
                <li>
                    📅 Berlaku:
                    {{ \Carbon\Carbon::parse($promo->tanggal_mulai)->format('d M Y') }}
                    –
                    {{ \Carbon\Carbon::parse($promo->tanggal_selesai)->format('d M Y') }}
                </li>

                @if(($promo->min_pembelian ?? 0) > 0)
                    <li>🛒 Min. pembelian: Rp {{ number_format($promo->min_pembelian, 0, ',', '.') }}</li>
                @endif

                @if($sisa !== null)
                    <li>
                        🎫 Sisa kuota:
                        @if($sisa <= 0)
                            <strong style="color: #c0392b;">Habis</strong>
                        @elseif($sisa <= 5)
                            <strong style="color: #e67e22;">{{ $sisa }} lagi</strong>
                            <span style="color: #8b7355; font-size: 13px;">/ {{ $promo->kuota }}</span>
                        @else
                            <strong style="color: #27ae60;">{{ $sisa }}</strong>
                            <span style="color: #8b7355; font-size: 13px;">/ {{ $promo->kuota }}</span>
                        @endif
                    </li>
                @endif
            </ul>

            {{-- Tombol --}}
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                @if($kuotaHabis)
                    <button type="button" disabled
                            style="background: #ddd; color: #888; border: none; padding: 12px 20px;
                                   border-radius: 10px; font-size: 14px; cursor: not-allowed;
                                   font-family: inherit; font-weight: 600;">
                        Kuota Habis
                    </button>
                @else
                    <button type="button" onclick="salinKode()"
                            style="background: #3f2a20; color: white; border: none; padding: 12px 20px;
                                   border-radius: 10px; font-size: 14px; cursor: pointer;
                                   font-family: inherit; font-weight: 600;">
                        Salin Kode
                    </button>
                @endif

                <a href="{{ url('/menu') }}"
                   style="background: #f5ebe0; color: #9c5638; padding: 12px 20px; border-radius: 10px;
                          font-size: 14px; text-decoration: none; font-weight: 600;">
                    Pesan Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function salinKode() {
    var el = document.getElementById('kode-promo');
    if (!el) return;
    var kode = el.innerText.trim();
    navigator.clipboard.writeText(kode).then(function () {
        if (typeof showToast === 'function') {
            showToast('Kode ' + kode + ' disalin', 'success');
        } else {
            alert('Kode disalin: ' + kode);
        }
    });
}
</script>
@endsection