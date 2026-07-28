@extends('layouts.app')

@section('content')
<div class="container" style="padding: 60px 24px 80px;">
    <div class="section-header">
        <h2>Lokasi Kami</h2>
        <p>Kunjungi Warso Restaurant di lokasi terbaik</p>
    </div>

    <div class="lokasi-wrapper">
        <div class="lokasi-info">
            <div class="info-item">
                <h4>📍 Alamat</h4>
                <p>Jl. Raya Warso No. 88<br>Kecamatan Warso, Kabupaten Warso</p>
            </div>
            <div class="info-item">
                <h4>🕐 Jam Operasional</h4>
                <p>Senin - Minggu<br>10:00 - 22:00 WIB</p>
            </div>
            <div class="info-item">
                <h4>📞 Kontak</h4>
                <p>+62 812-3456-7890<br>warso@restaurant.com</p>
            </div>
        </div>

        <div class="lokasi-map">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.123456789!2d110.123456!3d-7.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDcnMzQuMiJTIDExMMKwMDcnMjIuNiJF!5e0!3m2!1sid!2sid!4v123456789" 
                width="100%" 
                height="420" 
                style="border:0; border-radius: 20px;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </div>
</div>
@endsection