@extends('admin.layouts.app')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
    <h1 class="page-title" style="margin:0;">Tambah Promo</h1>
    <a href="{{ route('admin.promo.index') }}" style="color:#9c5638; text-decoration:none; font-size:14px;">← Kembali</a>
</div>

@if($errors->any())
    <div style="background:#f8d7da; color:#721c24; padding:14px 20px; border-radius:10px; margin-bottom:24px;">
        <ul style="margin:0; padding-left:18px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card" style="max-width:680px;">
    <form action="{{ route('admin.promo.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom:18px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#3f2a20; margin-bottom:6px;">Judul Promo *</label>
            <input type="text" name="judul" value="{{ old('judul') }}" required
                   style="width:100%; padding:10px 12px; border-radius:10px; border:1px solid #e8ddd0; font-size:14px; box-sizing:border-box;">
        </div>

        <div style="margin-bottom:18px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#3f2a20; margin-bottom:6px;">Kode Promo *</label>
            <input type="text" name="kode_promo" value="{{ old('kode_promo') }}" required
                   placeholder="Contoh: WARSO10"
                   style="width:100%; padding:10px 12px; border-radius:10px; border:1px solid #e8ddd0; font-size:14px; box-sizing:border-box;">
        </div>

        <div style="margin-bottom:18px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#3f2a20; margin-bottom:6px;">Deskripsi</label>
            <textarea name="deskripsi" rows="3"
                      style="width:100%; padding:10px 12px; border-radius:10px; border:1px solid #e8ddd0; font-size:14px; box-sizing:border-box; font-family:inherit;">{{ old('deskripsi') }}</textarea>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:18px;">
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#3f2a20; margin-bottom:6px;">Tipe Diskon *</label>
                <select name="tipe" required
                        style="width:100%; padding:10px 12px; border-radius:10px; border:1px solid #e8ddd0; font-size:14px;">
                    <option value="persen" {{ old('tipe') == 'persen' ? 'selected' : '' }}>Persen (%)</option>
                    <option value="nominal" {{ old('tipe') == 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                </select>
            </div>
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#3f2a20; margin-bottom:6px;">Nilai *</label>
                <input type="number" name="nilai" value="{{ old('nilai') }}" min="1" required
                       placeholder="10 atau 15000"
                       style="width:100%; padding:10px 12px; border-radius:10px; border:1px solid #e8ddd0; font-size:14px; box-sizing:border-box;">
            </div>
        </div>

        <div style="margin-bottom:18px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#3f2a20; margin-bottom:6px;">Min. Pembelian (Rp)</label>
            <input type="number" name="min_pembelian" value="{{ old('min_pembelian', 0) }}" min="0"
                   style="width:100%; padding:10px 12px; border-radius:10px; border:1px solid #e8ddd0; font-size:14px; box-sizing:border-box;">
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:18px;">
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#3f2a20; margin-bottom:6px;">Tanggal Mulai *</label>
                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required
                       style="width:100%; padding:10px 12px; border-radius:10px; border:1px solid #e8ddd0; font-size:14px; box-sizing:border-box;">
            </div>
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#3f2a20; margin-bottom:6px;">Tanggal Selesai *</label>
                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required
                       style="width:100%; padding:10px 12px; border-radius:10px; border:1px solid #e8ddd0; font-size:14px; box-sizing:border-box;">
            </div>
        </div>

        <div style="margin-bottom:20px;">
    <label style="display:block; font-weight:600; margin-bottom:8px;">Kuota pemakaian (opsional)</label>
    <input type="number" name="kuota" min="1" value="{{ old('kuota') }}"
           placeholder="Kosongkan = tidak terbatas"
           style="width:100%; padding:12px 16px; border:1px solid #ddd; border-radius:10px; font-size:15px;">
    <small style="color:#888;">Contoh: 50 → promo hanya bisa dipakai 50 kali</small>
</div>

        <div style="margin-bottom:18px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#3f2a20; margin-bottom:6px;">Gambar</label>
            <input type="file" name="gambar" accept="image/jpeg,image/png,image/webp"
                   style="width:100%; font-size:13px;">
        </div>

        <div style="margin-bottom:24px;">
            <label style="display:flex; align-items:center; gap:8px; font-size:14px; color:#3f2a20; cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                Aktifkan promo
            </label>
        </div>

        <button type="submit"
                style="background:#3f2a20; color:white; border:none; padding:12px 24px; border-radius:10px; font-size:14px; cursor:pointer; font-weight:600;">
            Simpan Promo
        </button>
    </form>
</div>
@endsection