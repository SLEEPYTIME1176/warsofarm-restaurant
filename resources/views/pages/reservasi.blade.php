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
                <textarea name="catatan" rows="3" placeholder="Contoh: Meja dekat jendela, ulang tahun, dll">{{ old('catatan') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; padding:16px; font-size:16px;">
                Konfirmasi Reservasi
            </button>
        </form>
    </div>
</div>
@endsection