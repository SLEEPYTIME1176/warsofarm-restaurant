@extends('layouts.app')

@section('content')
<div class="container" style="padding: 60px 24px 80px;">
    <div class="section-header">
        <h2>Lokasi Kami</h2>
        <p>Kebun Durian Warso Farm — Bogor</p>
    </div>

    <div class="lokasi-grid">
        {{-- Info --}}
        <div class="lokasi-info-col">

            {{-- Nama + Rating --}}
            <div class="info-card rating-card">
                <div>
                    <h3 style="font-size:1.25rem; margin-bottom:6px; color:#3f2a20;">Kebun Durian Warso Farm</h3>
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
                        <span style="font-size:1.3rem; font-weight:700; color:#3f2a20;">4,3</span>
                        <span style="color:#f4b400; font-size:1.1rem; letter-spacing:1px;">★★★★☆</span>
                        <span style="font-size:13px; color:#888;">(8.925 ulasan)</span>
                    </div>
                    <p style="font-size:13px; color:#6b5244; margin:0;">Kebun Buah · Perkebunan lokal</p>
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon">📍</div>
                <div>
                    <h4>Alamat</h4>
                    <p>
                        Jl. K.H. Halimi, Cipelang<br>
                        Kec. Cijeruk, Kabupaten Bogor<br>
                        Jawa Barat 16740
                    </p>
                    <p style="font-size:12px; color:#999; margin-top:6px;">Plus Code: 8Q5R+WF Cipelang</p>
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon">🕐</div>
                <div>
                    <h4>Jam Operasional</h4>
                    <div class="jam-list">
                        <div><span>Senin</span><span>09.00 – 17.00</span></div>
                        <div><span>Selasa</span><span>09.00 – 17.00</span></div>
                        <div><span>Rabu</span><span>09.00 – 17.00</span></div>
                        <div><span>Kamis</span><span>09.00 – 17.00</span></div>
                        <div><span>Jumat</span><span>09.00 – 17.00</span></div>
                        <div><span>Sabtu</span><span>09.00 – 17.00</span></div>
                        <div><span>Minggu</span><span>09.00 – 17.00</span></div>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon">📞</div>
                <div>
                    <h4>Kontak</h4>
                    <p>
                        <a href="tel:081367787355">0813-6778-7355</a>
                    </p>
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon">🌿</div>
                <div>
                    <h4>Tentang</h4>
                    <p>Perkebunan lokal dengan tur edukasi melalui kebun durian & buah naga, toko suvenir & kolam koi.</p>
                </div>
            </div>

            <a href="https://www.google.com/maps/search/?api=1&query=Kebun+Durian+Warso+Farm+Cijeruk+Bogor" 
               target="_blank" 
               class="btn btn-primary" 
               style="width:100%; text-align:center; padding:14px;">
                Lihat di Google Maps & Ulasan →
            </a>
        </div>

        {{-- Map --}}
        <div class="lokasi-map-col">
            <div class="map-wrapper">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.5!2d106.75!3d-6.65!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMzknMDAuMCJTIDEwNsKwNDUnMDAuMCJF!5e0!3m2!1sid!2sid!4v1700000000000"
                    width="100%" 
                    height="100%" 
                    style="border:0; border-radius:20px;" 
                    allowfullscreen="" 
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            
            <p class="map-note">
                * Ganti embed dengan lokasi akurat: Google Maps → Warso Farm → Share → Embed a map
            </p>
        </div>
    </div>
</div>


<style>
.lokasi-grid {
    display: grid;
    grid-template-columns: 400px 1fr;
    gap: 32px;
    max-width: 1100px;
    margin: 0 auto;
    align-items: start;
}

.lokasi-info-col {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.info-card {
    display: flex;
    gap: 16px;
    background: white;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(90, 55, 30, 0.06);
}

.rating-card {
    background: linear-gradient(135deg, #fff9f0, #fff);
    border: 1px solid #f0e6d8;
}

.info-icon {
    font-size: 20px;
    width: 42px;
    height: 42px;
    background: #f8f1e9;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.info-card h4 {
    font-size: 14px;
    font-weight: 600;
    color: #9c5638;
    margin-bottom: 6px;
}

.info-card p {
    font-size: 14px;
    color: #6b5244;
    line-height: 1.55;
    margin: 0;
}

.info-card a {
    color: #6b5244;
    text-decoration: none;
}
.info-card a:hover { color: #9c5638; }

.jam-list {
    font-size: 13.5px;
    color: #6b5244;
}
.jam-list div {
    display: flex;
    justify-content: space-between;
    padding: 3px 0;
    max-width: 220px;
}
.jam-list span:first-child {
    color: #8b7355;
}

.map-wrapper {
    height: 520px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 12px 36px rgba(90, 55, 30, 0.1);
    background: #e8f0e8;
}

.map-note {
    font-size: 12px;
    color: #999;
    margin-top: 12px;
    text-align: center;
}

@media (max-width: 900px) {
    .lokasi-grid { grid-template-columns: 1fr; }
    .map-wrapper { height: 340px; }
}
</style>
@endsection