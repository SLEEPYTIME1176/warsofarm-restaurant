@extends('layouts.app')

@section('content')
<div class="container" style="padding: 60px 24px 80px;">
    <div class="section-header">
        <h2>Hubungi Kami</h2>
        <p>Kami siap melayani Anda</p>
    </div>

    <div class="kontak-wrapper">
        <!-- Form -->
        <div class="form-card">
            <h3 style="margin-bottom: 24px; font-size: 1.4rem;">Kirim Pesan</h3>
            <form>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" placeholder="Masukkan nama Anda" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" placeholder="email@contoh.com" required>
                </div>
                <div class="form-group">
                    <label>Pesan</label>
                    <textarea rows="5" placeholder="Tulis pesan Anda di sini..." required></textarea>
                </div>
                <button type="button" onclick="alert('Pesan terkirim! Terima kasih.')" 
                        class="btn btn-primary" style="width:100%; padding:15px;">
                    Kirim Pesan
                </button>
            </form>
        </div>

        <!-- Info -->
        <div class="kontak-info">
            <div class="info-item">
                <h4>📍 Alamat</h4>
                <p>Jl. Raya Warso No. 88<br>Kecamatan Warso, Kabupaten Warso</p>
            </div>
            <div class="info-item">
                <h4>📞 Telepon</h4>
                <p>+62 812-3456-7890</p>
            </div>
            <div class="info-item">
                <h4>🕐 Jam Operasional</h4>
                <p>Senin - Minggu<br>10:00 - 22:00 WIB</p>
            </div>
            <div class="info-item">
                <h4>✉️ Email</h4>
                <p>warso@restaurant.com</p>
            </div>
        </div>
    </div>
</div>
@endsection