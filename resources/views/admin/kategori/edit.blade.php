@extends('admin.layouts.app')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
        <h1 class="page-title" style="margin:0;">Edit Kategori</h1>
        <a href="{{ route('admin.kategori.index') }}" class="btn" style="background:#eee; color:#333;">← Kembali</a>
    </div>

    <div class="card" style="max-width:600px;">
        <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom:24px;">
                <label style="display:block; font-weight:600; margin-bottom:8px;">Nama Kategori</label>
                <input type="text" name="nama_kategori" value="{{ $kategori->nama_kategori }}" required 
                       style="width:100%; padding:12px 16px; border:1px solid #ddd; border-radius:10px; font-size:15px;">
            </div>
            <button type="submit" class="btn btn-primary" style="padding:14px 28px;">Update Kategori</button>
        </form>
    </div>
@endsection
