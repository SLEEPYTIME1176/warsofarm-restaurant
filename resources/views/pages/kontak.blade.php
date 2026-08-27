@extends('layouts.app')

@section('content')
<div class="container" style="padding: 60px 24px 80px;">
    <div class="section-header">
        <h2>Hubungi Kami</h2>
        <p>Ada pertanyaan? Kirim pesan, kami siap membantu</p>
    </div>

    <div class="form-card" style="max-width:560px; margin:0 auto;">
        <form>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" placeholder="Masukkan nama Anda" required>
            </div>
            <div class="form-group">
                <label>Email / WhatsApp</label>
                <input type="text" placeholder="email@contoh.com atau 08xxxxxxxxxx" required>
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

        <div style="margin-top:28px; padding-top:24px; border-top:1px solid #f0e6d8; text-align:center;">
            <p style="font-size:14px; color:#6b5244; margin-bottom:8px;">Atau hubungi langsung:</p>
            <a href="tel:081367787355" style="font-size:16px; font-weight:600; color:#9c5638;">
                0813-6778-7355
            </a>
        </div>
    </div>
</div>
@endsection