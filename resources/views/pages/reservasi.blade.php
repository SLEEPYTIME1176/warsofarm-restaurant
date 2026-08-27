@extends('layouts.app')

@section('content')
<div class="container" style="padding: 60px 24px 80px;">
    <div class="section-header">
        <h2>Reservasi Meja</h2>
        <p>Pesan meja favorit Anda terlebih dahulu</p>
    </div>

    @if(session('success'))
        <div style="max-width:560px; margin:0 auto 30px; background:#d4edda; color:#155724; padding:16px 20px; border-radius:14px; text-align:center;">
            {{ session('success') }}
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('reservasi.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama Anda" required>
                @error('nama') <small style="color:red;">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Email (opsional)</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com">
            </div>

            <div class="form-group">
                <label>Nomor Telepon (opsional)</label>
                <input type="text" name="telepon" value="{{ old('telepon') }}" placeholder="08xxxxxxxxxx">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal') }}" required>
                    @error('tanggal') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>Waktu</label>
                    <input type="time" name="waktu" value="{{ old('waktu') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Jumlah Orang</label>
                <select name="jumlah_orang" required>
                    <option value="">Pilih jumlah orang</option>
                    <option value="2" {{ old('jumlah_orang') == 2 ? 'selected' : '' }}>2 Orang</option>
                    <option value="4" {{ old('jumlah_orang') == 4 ? 'selected' : '' }}>4 Orang</option>
                    <option value="6" {{ old('jumlah_orang') == 6 ? 'selected' : '' }}>6 Orang</option>
                    <option value="8" {{ old('jumlah_orang') == 8 ? 'selected' : '' }}>8 Orang</option>
                    <option value="10" {{ old('jumlah_orang') == 10 ? 'selected' : '' }}>10+ Orang</option>
                </select>
            </div>

            <div class="form-group">
                <label>Catatan (opsional)</label>
                <textarea name="catatan"
                          rows="4"
                          placeholder="Contoh:&#10;• Dekat jendela&#10;• Membawa bayi&#10;• Merayakan ulang tahun&#10;• Kursi roda">{{ old('catatan') }}</textarea>
                <small style="color:#8b7355; font-size:12.5px;">
                    Tulis kebutuhan khusus agar kami bisa siapkan lebih baik.
                </small>
            </div>

            {{-- Info jam operasional --}}
            <div class="reservasi-info-box">
                <p style="margin:0 0 8px;">
                    <strong>🕐 Reservasi tersedia</strong><br>
                    Setiap hari pukul <strong>09.00 – 17.00 WIB</strong>
                </p>
                <p style="margin:0;">
                    Reservasi minimal dilakukan <strong>30 menit</strong> sebelum kedatangan.
                </p>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; padding:16px; font-size:16px;">
                Konfirmasi Reservasi
            </button>

            {{-- Info konfirmasi --}}
            <p class="reservasi-confirm-note">
                Setelah reservasi dikirim, tim Warso akan menghubungi Anda untuk konfirmasi.
                Status dapat dilihat di
                <a href="{{ route('riwayat.reservasi') }}" style="color:#9c5638; font-weight:600;">Riwayat Reservasi</a>
        </form>
    </div>
</div>

<style>
.reservasi-info-box {
    background: #fff8f0;
    border: 1px solid #f0e0d0;
    border-radius: 14px;
    padding: 14px 16px;
    margin-bottom: 16px;
    font-size: 13.5px;
    color: #5c4033;
    line-height: 1.55;
}

.reservasi-confirm-note {
    margin-top: 14px;
    margin-bottom: 0;
    text-align: center;
    font-size: 13px;
    color: #8b7355;
    line-height: 1.5;
}

.form-card textarea[name="catatan"] {
    border-radius: 12px;
    border: 1.5px solid #e8ddd0;
    padding: 12px 14px;
    font-size: 14px;
    line-height: 1.5;
    resize: vertical;
    width: 100%;
    box-sizing: border-box;
    font-family: inherit;
}
.form-card textarea[name="catatan"]:focus {
    outline: none;
    border-color: #9c5638;
}
</style>
@endsection