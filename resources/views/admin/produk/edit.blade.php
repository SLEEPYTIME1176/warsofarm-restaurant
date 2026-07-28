@extends('admin.layouts.app')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
        <h1 class="page-title" style="margin:0;">Edit Menu</h1>
        <a href="{{ route('admin.produk.index') }}" class="btn" style="background:#eee; color:#333;">← Kembali</a>
    </div>

    <div class="card" style="max-width:700px;">
        <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div style="margin-bottom:20px;">
        <label style="display:block; font-weight:600; margin-bottom:8px;">Nama Menu</label>
        <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" required 
               style="width:100%; padding:12px 16px; border:1px solid #ddd; border-radius:10px; font-size:15px;">
    </div>

    <div style="margin-bottom:20px;">
        <label style="display:block; font-weight:600; margin-bottom:8px;">Kategori</label>
        <select name="kategori_id" required
                style="width:100%; padding:12px 16px; border:1px solid #ddd; border-radius:10px; font-size:15px;">
            @foreach($kategoris as $kat)
                <option value="{{ $kat->id }}" {{ $produk->kategori_id == $kat->id ? 'selected' : '' }}>
                    {{ $kat->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom:20px;">
        <label style="display:block; font-weight:600; margin-bottom:8px;">Harga</label>
        <input type="number" name="harga" value="{{ $produk->harga }}" required min="0"
               style="width:100%; padding:12px 16px; border:1px solid #ddd; border-radius:10px; font-size:15px;">
    </div>

    <div style="margin-bottom:20px;">
        <label style="display:block; font-weight:600; margin-bottom:8px;">Stok</label>
        <input type="number" name="stok" value="{{ $produk->stok }}" min="0"
               style="width:100%; padding:12px 16px; border:1px solid #ddd; border-radius:10px; font-size:15px;">
    </div>

    <div style="margin-bottom:20px;">
        <label style="display:block; font-weight:600; margin-bottom:8px;">Deskripsi</label>
        <textarea name="deskripsi" rows="4"
                  style="width:100%; padding:12px 16px; border:1px solid #ddd; border-radius:10px; font-size:15px;">{{ $produk->deskripsi }}</textarea>
    </div>

    <div style="margin-bottom:20px;">
    <label style="display:block; font-weight:600; margin-bottom:8px;">Foto Menu</label>
    
    @if($produk->foto)
        <div style="margin-bottom:12px;">
            <img src="{{ asset('storage/'.$produk->foto) }}" alt="Foto" style="width:120px; height:120px; object-fit:cover; border-radius:12px; border:1px solid #eee;">
        </div>

        <label style="display:flex; align-items:center; gap:8px; margin-bottom:12px; cursor:pointer;">
            <input type="checkbox" name="hapus_foto" value="1">
            <span style="color:#c0392b; font-size:14px;">Hapus foto saat ini</span>
        </label>
    @endif

    <input type="file" name="foto" accept="image/*"
           style="width:100%; padding:12px; border:1px solid #ddd; border-radius:10px;">
    <small style="color:#888;">Kosongkan jika tidak ingin mengubah foto</small>
</div>

    <div style="margin-bottom:28px;">
        <label style="display:flex; align-items:center; gap:10px; cursor:pointer;">
            <input type="checkbox" name="is_popular" value="1" {{ $produk->is_popular ? 'checked' : '' }}>
            <span>Jadikan Menu Populer</span>
        </label>
    </div>

    <button type="submit" class="btn btn-primary" style="padding:14px 28px;">
        Update Menu
    </button>
</form>
    </div>
@endsection