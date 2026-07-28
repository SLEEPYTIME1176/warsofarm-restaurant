@extends('admin.layouts.app')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
        <h1 class="page-title" style="margin:0;">Kelola Kategori</h1>
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
    </div>

    @if(session('success'))
        <div style="background:#d4edda; color:#155724; padding:14px 20px; border-radius:10px; margin-bottom:24px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#f8d7da; color:#721c24; padding:14px 20px; border-radius:10px; margin-bottom:24px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Jumlah Menu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $item->nama_kategori }}</strong></td>
                        <td>{{ $item->slug }}</td>
                        <td>{{ $item->produks()->count() }}</td>
                        <td>
                            <a href="{{ route('admin.kategori.edit', $item->id) }}" class="btn btn-sm" style="background:#3498db; color:white; margin-right:6px;">Edit</a>
                            
                            <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:40px; color:#999;">Belum ada kategori</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection