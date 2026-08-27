@extends('admin.layouts.app')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
        <h1 class="page-title" style="margin:0;">Tambah Menu Baru</h1>
        <a href="{{ route('admin.produk.index') }}" class="btn" style="background:#eee; color:#333;">← Kembali</a>
    </div>

    <div class="card" style="max-width:700px;">
        <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div style="margin-bottom:20px;">
        <label style="display:block; font-weight:600; margin-bottom:8px;">Nama Menu</label>
        <input type="text" name="nama_produk" required 
               style="width:100%; padding:12px 16px; border:1px solid #ddd; border-radius:10px; font-size:15px;"
               placeholder="Contoh: Nasi Goreng Special">
    </div>

    <div style="margin-bottom:20px;">
        <label style="display:block; font-weight:600; margin-bottom:8px;">Kategori</label>
        <select name="kategori_id" required
                style="width:100%; padding:12px 16px; border:1px solid #ddd; border-radius:10px; font-size:15px;">
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategoris as $kat)
                <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom:20px;">
    <label style="display:block; font-weight:600; margin-bottom:8px;">Harga</label>
    <input type="number" name="harga" required min="0"
           style="width:100%; padding:12px 16px; border:1px solid #ddd; border-radius:10px; font-size:15px;"
           placeholder="28000">
</div>

<div class="form-group">
    <label>Badge (opsional)</label>
    <select name="badge">
        <option value="">— Tidak ada —</option>
        <option value="terlaris" {{ old('badge') == 'terlaris' ? 'selected' : '' }}>🔥 Terlaris</option>
        <option value="favorit" {{ old('badge') == 'favorit' ? 'selected' : '' }}>⭐ Favorit</option>
        <option value="baru" {{ old('badge') == 'baru' ? 'selected' : '' }}>🆕 Baru</option>
    </select>
</div>

{{-- ===== TAMBAHKAN INI ===== --}}
<div style="margin-bottom:20px;">
    <label style="display:block; font-weight:600; margin-bottom:8px;">Satuan</label>
    <select name="satuan"
            style="width:100%; padding:12px 16px; border:1px solid #ddd; border-radius:10px; font-size:15px;">
        <option value="porsi">Porsi</option>
        <option value="kg">Kg</option>
        <option value="500g">500g</option>
        <option value="250g">250g</option>
        <option value="pax">Pax</option>
    </select>
</div>

    <div style="margin-bottom:20px;">
        <label style="display:block; font-weight:600; margin-bottom:8px;">Stok</label>
        <input type="number" name="stok" value="0" min="0"
               style="width:100%; padding:12px 16px; border:1px solid #ddd; border-radius:10px; font-size:15px;">
    </div>

    <div style="margin-bottom:20px;">
        <label style="display:block; font-weight:600; margin-bottom:8px;">Deskripsi</label>
        <textarea name="deskripsi" rows="4"
                  style="width:100%; padding:12px 16px; border:1px solid #ddd; border-radius:10px; font-size:15px;"
                  placeholder="Deskripsi singkat menu..."></textarea>
    </div>

    <div style="margin-bottom:20px;">
        <label style="display:block; font-weight:600; margin-bottom:8px;">Foto Menu</label>
        <input type="file" name="foto" accept="image/*"
               style="width:100%; padding:12px; border:1px solid #ddd; border-radius:10px;">
        <small style="color:#888;">Format: JPG, PNG, WEBP. Maksimal 2MB</small>
    </div>

    <div style="margin-bottom:28px;">
        <label style="display:flex; align-items:center; gap:10px; cursor:pointer;">
            <input type="checkbox" name="is_popular" value="1">
            <span>Jadikan Menu Populer</span>
        </label>
    </div>

    <button type="submit" class="btn btn-primary" style="padding:14px 28px;">
        Simpan Menu
    </button>
</form>
    </div>
@endsection