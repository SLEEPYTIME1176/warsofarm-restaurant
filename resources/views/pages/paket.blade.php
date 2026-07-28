@extends('layouts.app')

@section('content')
<div class="container" style="padding: 60px 24px 80px;">
    <div class="section-header">
        <h2>Paket Spesial</h2>
        <p>Pilihan paket untuk keluarga atau acara</p>
    </div>

    <div class="paket-grid">
        <!-- Paket 1 -->
        <div class="paket-card">
            <div class="paket-badge">PAKET KELUARGA</div>
            <div class="paket-body">
                <h3>Paket 4 Orang</h3>
                <ul>
                    <li>✅ Nasi Goreng</li>
                    <li>✅ Sate Ayam 8 pcs</li>
                    <li>✅ Es Teh Manis</li>
                    <li>✅ Keripik</li>
                </ul>
                <div class="paket-footer">
                    <span class="price">Rp 185.000</span>
                    <button class="btn btn-primary btn-sm">Pilih Paket</button>
                </div>
            </div>
        </div>

        <!-- Paket 2 -->
        <div class="paket-card">
            <div class="paket-badge">PAKET ROMANTIS</div>
            <div class="paket-body">
                <h3>Paket 2 Orang</h3>
                <ul>
                    <li>✅ Nasi Goreng Special</li>
                    <li>✅ Ayam Bakar</li>
                    <li>✅ Es Jeruk</li>
                    <li>✅ Pudding</li>
                </ul>
                <div class="paket-footer">
                    <span class="price">Rp 120.000</span>
                    <button class="btn btn-primary btn-sm">Pilih Paket</button>
                </div>
            </div>
        </div>

        <!-- Paket 3 -->
        <div class="paket-card">
            <div class="paket-badge">PAKET BESAR</div>
            <div class="paket-body">
                <h3>Paket 8 Orang</h3>
                <ul>
                    <li>✅ Nasi Liwet</li>
                    <li>✅ Ayam Bakar 2 ekor</li>
                    <li>✅ Sate 16 pcs</li>
                    <li>✅ Minuman + Snack</li>
                </ul>
                <div class="paket-footer">
                    <span class="price">Rp 350.000</span>
                    <button class="btn btn-primary btn-sm">Pilih Paket</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection