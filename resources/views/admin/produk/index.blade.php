@extends('admin.layouts.app')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
        <h1 class="page-title" style="margin:0;">Kelola Menu</h1>
        <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">+ Tambah Menu</a>
    </div>

    @if(session('success'))
        <div style="background:#d4edda; color:#155724; padding:14px 20px; border-radius:10px; margin-bottom:24px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Populer</th>
                    <th>Aksi</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produks as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $item->nama_produk }}</strong></td>
                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>{{ $item->is_popular ? '✅' : '❌' }}</td>
                        <td>
                            <a href="{{ route('admin.produk.edit', $item->id) }}" class="btn btn-sm" style="background:#3498db; color:white; margin-right:6px;">Edit</a>
    
                            <form action="{{ route('admin.produk.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                        <td>
                            @if($item->foto)
                            <img src="{{ asset('storage/'.$item->foto) }}" style="width:50px; height:50px; object-fit:cover; border-radius:8px;">
                            @else
                            <span style="color:#aaa;">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px; color:#999;">Belum ada menu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection